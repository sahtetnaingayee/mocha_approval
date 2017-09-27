<?php
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', 'HomeController@getClientLogin')->name('/');
Route::get('/home', 'HomeController@getPage')->name('home');
// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/redirect', 'SocialAuthController@redirect')->name('redirect');

Route::get('login', [ 'as' => 'login', 'uses' => 'HomeController@getLogin']);
Route::get('client-login', [ 'as' => 'login', 'uses' => 'HomeController@getClientLogin']);

Route::post('client-login', [ 'as' => 'client-login', 'uses' => 'HomeController@postClientLogin']);


Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
	{

	    // Send an array of permissions to request
	    $login_url = $fb->getLoginUrl(['email','manage_pages','publish_pages','ads_management']);

	    // Obviously you'd do this in blade :)
	    return view('welcome',compact('login_url'));
	});

	Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
	{
	    // Obtain an access token.
	    try {
	        $token = $fb->getAccessTokenFromRedirect();
	    } catch (Facebook\Exceptions\FacebookSDKException $e) {
	        dd($e->getMessage());
	    }

	    // Access token will be null if the user denied the request
	    // or if someone just hit this URL outside of the OAuth flow.
	    if (! $token) {
	        // Get the redirect helper
	        $helper = $fb->getRedirectLoginHelper();

	        if (! $helper->getError()) {
	            abort(403, 'Unauthorized action.');
	        }

	        // User denied the request
	        dd(
	            $helper->getError(),
	            $helper->getErrorCode(),
	            $helper->getErrorReason(),
	            $helper->getErrorDescription()
	        );
	    }

	    if (! $token->isLongLived()) {
	        // OAuth 2.0 client handler
	        $oauth_client = $fb->getOAuth2Client();

	        // Extend the access token.
	        try {
	            $token = $oauth_client->getLongLivedAccessToken($token);
	        } catch (Facebook\Exceptions\FacebookSDKException $e) {
	            dd($e->getMessage());
	        }
	    }

	    $fb->setDefaultAccessToken($token);

	    // Save for later
	    Session::put('fb_user_access_token', (string) $token);

	    // Get basic info on the user from Facebook.
	    try {
	        $response = $fb->get('/me?fields=id,name,email,adaccounts');
	    } catch (Facebook\Exceptions\FacebookSDKException $e) {
	        dd($e->getMessage());
	    }

	    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
	    //$facebook_user = $response->getGraphUser();

	    $facebook_user = json_decode($response->getBody(),true);

	    // Create the user if it does not exist or update the existing entry.
	    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
	    	
	    
	    $adaccounts=$facebook_user['adaccounts'];
	    $adaccounts=$adaccounts['data'][0];



	   	if(isset($facebook_user['email']) && $facebook_user['email']!=''){

	   		$user = User::where('email',$facebook_user['email'])->first();

	   	}else{

	   		$user = User::where('email','mm@gmail.com')->first();	
	   	}


	    if (!$user) {


	        $user = User::create([
	            'email' =>isset($facebook_user['email']) && $facebook_user['email']!=''? $facebook_user['email']:'mm@gmail.com',
	            'name' =>$facebook_user['name'],
	            'provider_user_id' =>$facebook_user['id'],
	        	'provider' => 'facebook',
	        	'access_token'=>(string) $token,
	        	'account_id'=>$adaccounts['account_id'],
	        	'ads_id'=>$adaccounts['id']
	        	
	        ]);

	    }else{

			$user->email= isset($facebook_user['email']) && $facebook_user['email']!=''? $facebook_user['email']:'mm@gmail.com';
			$user->name=$facebook_user['name'];
			$user->access_token=(string) $token;
			$user->provider='facebook';
			$user->account_id=$adaccounts['account_id'];
			$user->ads_id=$adaccounts['id'];

			$user->save();
	    }


	    

	    // Log the user into Laravel
	    Auth::login($user);

	    return redirect('page');

	    //return redirect('/')->with('message', 'Successfully logged in with Facebook');
	});

	

Route::group(['middleware' => ['auth','web']], function () {


	Route::get('admin_post/{user_id}/{date}','AdminController@getNewPagePost');

	Route::get('admin_post/{id}/basic','AdminController@getPostBasic');
	Route::post('admin_post/{id}/basic','AdminController@postPostBasic');
	Route::get('admin_page/{id}','AdminController@getPageInfo');
	Route::get('admin_page/{id}/listview','AdminController@getPageListView');

	Route::get('admin_post/{pageid}/','AdminController@getPagePost');

	Route::get('admin_page/post/{pageId}/{postId}','AdminController@getPostInfo');

	Route::get('admin_page/user/{pageid}','AdminController@getPageUser');
	Route::get('admin_page/new_user/{pageid}','AdminController@getAssignUser');
	Route::post('admin_page/new_user/{pageid}','AdminController@postAssignUser');


	
	
	
	Route::get('/callback', 'SocialAuthController@callback');

	Route::get('page','HomeController@getPage');

	Route::get('page/basic','HomeController@getPageBasic');

	Route::post('page/basic','HomeController@postPageBasic');

	Route::get('listedpage','HomeController@getListedPage');

	Route::get('page/{id}/post','HomeController@getPagePost');


	Route::get('post/{id}/basic','HomeController@getPostBasic');
	Route::post('post/{id}/basic','HomeController@postPostBasic');

	Route::get('post/{id}/promote','HomeController@getPostPromote');

	Route::get('page/{id}','HomeController@getPageInfo');


	/* CAMPAIGN */

	Route::get('campaign/','CampaignController@getCampaignList');
	Route::get('campaign/basic','CampaignController@getCampaignBasic');

	Route::post('campaign/basic','CampaignController@postCampaignBasic');

	Route::get('page_post/{page_id}','CampaignController@getPagePost');

	Route::get('home','HomeController@getHome');

	Route::get('cpage/{pageId}','HomeController@getClientPage');

	Route::post('comment','HomeController@postComment');
	Route::post('approve','HomeController@postApprove');

	Route::get('postcount/{date?}','HomeController@getPostCount');

	Route::get('post/{date}','HomeController@getDatePost');

	Route::get('approval/{pageId}','HomeController@getApproval');
	Route::get('scheduled/{pageId}','HomeController@getScheduled');

	Route::get('calendar/{pageId?}','HomeController@getCalendar');

	

});
