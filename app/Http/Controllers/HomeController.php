<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Facebook;
use Auth;
use DateTime;
use App\Models\Page;
use App\Models\Comment;
use App\Models\Post;
use Flash;
use File;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use FacebookAds\Object\AdAccountUser;
use Facebook\FileUpload\FacebookFile;
use Response;
use DB;





class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {


        $this->fb=$fb;

        $this->firebase = new \Geckob\Firebase\Firebase(public_path()."/fir-310b5-firebase-adminsdk-xa8od-f44026dc49.json");



    }

    public function getHome(){

        $list=Post::orderBy('created_at','DESC')->get();
        
        return view('frontend.home',compact('list'));
    }

    public function postComment(Request $request){

        if($request->ajax()){

            $info=new Comment;

            $info->created_by=0;
            $info->message=$request->message;
            $info->via=VIA_CLIENT;
            $info->post_id=$request->post_id;

            $info->save();

            $html=view('frontend.comment',compact('info'))->render();



            return Response::json(array('success' => true,'html'=>$html));    

        }

    }

    public function postApprove(Request $request){

        if($request->ajax()){

            $info=Post::where('post_id',$request->post_id)->first();

            $info->status=APPROVED;

            $index=$request->index;

            return Response::json(array('success' => true,'index'=>$index));    

        }

    }

    public function getPostCount(Request $request,$type=0){


        if($request->ajax()){


            $list=Post::select(DB::raw('DATE(created_at) as title'),'created_by as icon','created_at as start')->get();
            return json_encode($list);
        }

    }

    public function getDatePost($user_id=0,$date=''){


        $list=Post::orderBy('created_at','DESC')->get();
        
        return view('frontend.home',compact('list'));

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {


        if(Auth::user()){

            return redirect('page');

        }else{

            $login_url = $this->fb->getLoginUrl(['email','manage_pages','publish_pages','ads_management','ads_read']);
        
            return view('welcome',compact('login_url'));

        }
        
    }


    public function index(){

        return view('home');
    }


    public function getPage(){


        $list=Page::get();

        return view('backend.page',compact('list'));

        // $this->fb->setDefaultAccessToken((string) Auth::user()->access_token);

        // $response = $this->fb->get('/me?fields=accounts{picture{url},cover,name,access_token,category}');

        // $list=json_decode($response->getBody());

        // $list=$list->accounts->data;

        

    }

    public function getPageBasic(){

        $this->fb->setDefaultAccessToken((string) Auth::user()->access_token);

        $response = $this->fb->get('/me?fields=accounts{picture{url},cover,name,access_token,category}');

        $list=json_decode($response->getBody());

        $list=$list->accounts->data;

        return view('backend.page_basic',compact('list'));

    }

    public function postPageBasic(Request $request){

        // $this->firebase->setPath('pages/');

        

        $page=$request->page;

        if(count($page)){

            foreach ($page as $value) {

                $tmp_page=explode('SHNA',$value);


                $info=new Page;

                $info->page_id=$tmp_page[0];
                $info->name=$tmp_page[1];
                $info->access_token=$tmp_page[2];
                $info->profile_path=$tmp_page[3];
                $info->cover_path=$tmp_page[4];
                $info->category=$tmp_page[5];
                $info->status=ACTIVE;


                $info->save();
                // $this->firebase->push([

                //     'id'  =>$tmp_page[0],
                //     'name' =>$tmp_page[1],
                //     'access_token' =>$tmp_page[2],
                //     'profile_path'=>$tmp_page[3],
                //     'cover_path'=>$tmp_page[4],
                    
                // ]);
                // # code...
            }

            Flash::success('Successfully saved.');

            return redirect('page');
        }

    } 

    public function getListedPage(){

        $list=json_decode($this->firebase->get('pages'));

        return view('backend.listedpage',compact('list'));

    }

    public function getPagePost($id=0){

        $page=Page::where('page_id',$id)->first();

        $list=Post::where('page_id',$id)->orderBy('created_at','DESC')->get();

        return view('backend.page_post',compact('list','id','page'));
    }

    public function getPostBasic($pageId=''){


        $page=Page::where('page_id',$pageId)->first();

        if($page==null){

            die("Invalid Request.");

        }

        return view('backend.new_post',compact('pageId','page'));

    }

    public function postPostBasic(Request $request,$pageId=''){

        $page=Page::where('page_id',$pageId)->first();

        $accessToken=$page->access_token;

        $accessToken='EAADeFKZBZCWNEBAPwDM7YJ8FFw98aMUUrRBinH5cPNUCqJyAjxrRNisRlC44ZAZB8TaB0bps4sElGZBbk6XERpCIqPQhoax2d0nWrv6PmtETcxaiUmPtheqN6o1weZBK8Soahd5uDIZCIhZAp4GnYs39whZAhZANwZBYbTVAEVaLUfQ31cioO9ZA4GlVFLqZA0IE9ZC2ivq3WleGnZBJsKIytuAmRXe';

        $scheduled_publish_time='';

        /* IF PHOTO */

        if($request->post_type==PHOTO){


            if($request->publish_type==SCHEDULED){ /* IF SCHEDULED */


                $scheduled_publish_time=strtotime($request->date." ".$request->time);

                $message=array(

                    'message'=>$request->message,
                    'source'=>$this->fb->fileToUpload($request->file),
                    'published'=>false,
                    'scheduled_publish_time'=>$scheduled_publish_time

                );

            }else{ /* PUBLISHED */

                $message=array(
                    'message'=>$request->message,
                    'source'=>$this->fb->fileToUpload($request->file),
                    'published'=>true,
                    

                );
            }

            $response=$this->fb->post('/'.$pageId.'/photos',$message,$accessToken);


        }else{/* IF VIDEO */

            /* FIRST UPLOAD FILE TO THE LOCAL PATH */

            $file = $request->file('file');
   
        
            $fileName=$file->getClientOriginalName();

            $fileExtension=$file->getClientOriginalExtension();
      
   
            //Move Uploaded File
            $uploadPath =public_path().'/video'.'/';

            $file->move($uploadPath,$file->getClientOriginalName());

            /* UPLOADING VIDEO THUMBNAIL*/

            $thumb_file = $request->file('thumbnail');
   
        
            $thumb_fileName=$thumb_file->getClientOriginalName();

            $thumb_fileExtension=$thumb_file->getClientOriginalExtension();
      
   
            //Move Uploaded File
            $thumb_uploadPath =public_path().'/video'.'/';

            $thumb_file->move($thumb_uploadPath,$thumb_file->getClientOriginalName());


            if($request->publish_type==SCHEDULED){ /* IF SCHEDULED */

                $message=array(

                    'title'=>$request->message,
                    'description'=>$request->message,
                    'thumb'=>new FacebookFile($thumb_uploadPath.'/'.$thumb_fileName),
                    'source'=>$this->fb->VideoToUpload($uploadPath.'/'.$fileName),
                    'published'=>false,
                    'scheduled_publish_time'=>$scheduled_publish_time

                );

            }else{ /* PUBLISHED */

                $message=array(
                    'title'=>$request->message,
                    'description'=>$request->message,
                    'thumb'=>new FacebookFile($thumb_uploadPath.'/'.$thumb_fileName),
                    'source'=>$this->fb->VideoToUpload($uploadPath.'/'.$fileName),
                    'published'=>true
                );
            }


            $response=$this->fb->post('/'.$pageId.'/videos',$message,$accessToken);

            /* REMOVING LOCAL FILE */

            if(File::exists($uploadPath.'/'.$fileName)){

                File::delete($uploadPath.'/'.$fileName);
            }
            if(File::exists($thumb_uploadPath.'/'.$thumb_fileName)){

                File::delete($thumb_uploadPath.'/'.$thumb_fileName);
            }
        }



        $response=json_decode($response->getBody());



        $post=new Post();

        $post_id='';

        $post->message=(nl2br($request->message));

        $post->page_id=$pageId;

        if($request->post_type==PHOTO){

            if($request->publish_type==SCHEDULED){

                $post_id=$response->id;    

            }else{

                $post_id=$response->post_id;        
            }

        }else{

            $post_id=$response->id;    

        }


        $this->fb->setDefaultAccessToken((string) Auth::user()->access_token);

        if($request->post_type==PHOTO){

            $tmp_post=$this->fb->get($post_id.'?fields=picture');

        
        }else{

            $tmp_post=$this->fb->get($post_id.'?fields=picture,status,scheduled_publish_time');    
        }



        $tmp_post=json_decode($tmp_post->getBody());

        
        if($request->post_type==PHOTO){

            $post->image_path=$tmp_post->picture;
            $post->type="photo";
            $post->is_published='live';


        }else{

            $post->image_path=$tmp_post->picture;
            $post->type='video';
            $post->is_published=$tmp_post->status->video_status;
        }

        if($request->publish_type==SCHEDULED){

            $post->scheduled_publish_time=$scheduled_publish_time;
        }
        

        $post->post_id=$post_id;
        
        

        
        $post->created_by=Auth::user()->id;

        $post->save();

        Flash::success("Successfully published.");

        return redirect()->back();


    }

    public function getPostPromote($id=0){

        Api::init(env('FACEBOOK_APP_ID'),env('FACEBOOK_APP_SECRET'),Auth::user()->access_token);

        $api = Api::instance();
        


    }



}
