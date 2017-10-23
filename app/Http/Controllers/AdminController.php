<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Facebook;
use Auth;
use DateTime;
use App\Models\Page;
use App\Models\PageUser;
use App\Models\Comment;
use App\Models\Post;
use App\Models\AdminPost;
use Flash;
use App\User;
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
use Hash;
use Illuminate\Support\Facades\Input;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function getNewPagePost($pageId='',$date=''){

    	$page=Page::where('page_id',$pageId)->first();

    	if($page==null){

    		dd("Invalid Request.");
    	}
    	return view('backend.page.post_basic',compact('page','date','pageId'));
    }


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


            $list=AdminPost::select(DB::raw('DATE(created_at) as title'),'created_by as icon','page_id','id','created_at as start, status')->get();
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

    public function postLogin(Request $request){

        if (Auth::attempt(['email' => $request->email, 'password' =>$request->password,'type'=>ADMIN])) {

            return redirect('page');

        }else{

            Flash::warning("Invalid Password.");

            return redirect()->back();
        }

    }


    public function index(){

        return view('home');
    }


    public function getPage(){


        $list=Page::get();

        return view('backend.page',compact('list'));

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

    public function getPagePost(Request $request,$pageId=0){

        if($request->ajax()){


            $list=AdminPost::select(DB::raw('substring(message,1,10)  as title'),'created_by as icon','post_date as start','image_path','page_id','id')->where('page_id',$pageId)->get();



            return json_encode($list);
        }
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

        if($page==null){

            dd("Invalid Request.");
        }

        $info=$request->id==0?new AdminPost:AdminPost::find($request->id);

        $info->page_id=$pageId;
        $info->status=REIVEW;
        $info->message=(nl2br($request->message));

        if($request->post_type==PHOTO){/* If PHOTO */



            $info->type=PHOTO;


            if (Input::hasFile('file'))
            {
                //
                $file = $request->file('file');
       
            
                $fileName=$file->getClientOriginalName();

                $fileExtension=$file->getClientOriginalExtension();
          
       
                //Move Uploaded File
                $uploadPath ='photos'.'/';

                $file->move($uploadPath,$file->getClientOriginalName());

                $info->image_path=$uploadPath.$file->getClientOriginalName();
            }


        }else{

            $info->type=VIDEO;

            /* UPLOADING VIDEO THUMBNAIL*/

            if (Input::hasFile('file')){

                

                $thumb_file = $request->file('file');
       
            
                $thumb_fileName=$thumb_file->getClientOriginalName();

                $thumb_fileExtension=$thumb_file->getClientOriginalExtension();
          
       
                //Move Uploaded File
                $thumb_uploadPath ='photos'.'/';

                $thumb_file->move($thumb_uploadPath,$thumb_file->getClientOriginalName());

                $info->image_path=$thumb_uploadPath.$thumb_file->getClientOriginalName();
            }
        }

        $info->post_time=date("H:i:s",strtotime($request->time));
        $info->post_date=$request->date;
        $info->created_by=Auth::user()->id;
        $info->translate=$request->translate;
        $info->currency=$request->currency;
        $info->budget=$request->budget==''?0:$request->budget;

        $info->save();

        Flash::success("Successfully saved.");

        return redirect('admin_page/'.$pageId);

    }

    public function getPostPromote($id=0){

        Api::init(env('FACEBOOK_APP_ID'),env('FACEBOOK_APP_SECRET'),Auth::user()->access_token);

        $api = Api::instance();
        


    }

    public function getPageInfo($pageId=0){

        $page=Page::where('page_id',$pageId)->first();

        return view('backend.page.page_info',compact('page','pageId'));

    }

    public function getPageListView($pageId=0){

        $page=Page::where('page_id',$pageId)->first();

        if($page==null){

            dd("Invalid Request.");
        }

        $list=AdminPost::where('page_id',$pageId)->orderBy('created_at','DESC')->get();

        return view('backend.page.list_page_info',compact('page','pageId','list'));
    }

    public function getPostInfo($pageId=0,$postId=0){

        $info=AdminPost::find($postId);

        if($info==null){

            dd("Invalid Request.");
        }

        $page=Page::where('page_id',$pageId)->first();
        $date=$info->post_date;

        return view('backend.page.edit_post_basic',compact('info','page','pageId','date'));

    }

    public function getPageUser($pageId=''){

        $page=Page::where('page_id',$pageId)->first();

        if($page==null){

            dd("Invalid Request.");

        }

        $list=PageUser::where('page_id',$pageId)->get();



        return view('backend.page.user',compact('page','pageId','list'));

    }

    public function getAssignUser($pageId=''){

        $page=Page::where('page_id',$pageId)->first();

        $list=PageUser::where('page_id',$pageId)->get();

        $user_list=User::where('id','!=',Auth::user()->id)->pluck('email','id');
        

        if($page==null){

            dd("Invalid Request.");

        }

        return view('backend.page.new_user',compact('pageId','page','list','user_list'));
    }

    public function postAssignUser(Request $request,$pageId=''){

        $page=Page::where('page_id',$pageId)->first();

        if($page==null){

            dd("Invalid Request.");

        }

        $info=User::where('email',$request->email)->first();

        if($info!=null){

            Flash::warning("User already exist.");

            return redirect()->back();

        }


        $user=new User;

        $user->name=$request->name;
        $user->email=$request->email;
        $user->provider='';
        $user->provider_user_id='';
        $user->access_token='';
        $user->account_id='';
        $user->ads_id='';
        $user->type=CLIENT;
        $user->password=Hash::make($request->password);

        $user->save();


        $info=new PageUser;

        $info->page_id=$pageId;
        $info->user_id=$user->id;
        $info->created_by=Auth::user()->id;

        $info->save();
        Flash::success("Successfully saved.");

        return redirect()->back();
    }

    public function postAssignExistingUser(Request $request,$pageId=''){



        $page=Page::where('page_id',$pageId)->first();

        if($page==null){

            dd("Invalid Request.");

        }

        $info=PageUser::where('user_id',$request->user_id)->where('page_id',$pageId)->first();

        if($info!=null){

            Flash::warning("Already assigned.");

            return redirect()->back();
        }

        $info=User::where('id',$request->user_id)->first();


        $info=new PageUser;

        $info->page_id=$pageId;
        $info->user_id=$request->user_id;
        $info->created_by=Auth::user()->id;
        $info->type=$request->type;

        $info->save();
        Flash::success("Successfully saved.");

        return redirect()->back();
    }




}
