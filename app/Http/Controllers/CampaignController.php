<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FacebookAds\Api;
use Auth;
use Response;
use App\Models\Page;
use App\Models\Post;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Search\TargetingSearchTypes;
use FacebookAds\Object\Targeting;
use FacebookAds\Object\Fields\TargetingFields;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use FacebookAds\Object\AdImage;
use FacebookAds\Object\Fields\AdImageFields;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Ad;
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdCreativeLinkData;
use FacebookAds\Object\Fields\AdCreativeLinkDataFields;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;





class CampaignController extends Controller
{
    //

    public function getPagePost(Request $request,$page_id){

    	if($request->ajax()){

    		$post_list=Post::where('page_id',$page_id)->orderBy('created_at','DESC')->pluck('message','post_id');

    		return Response::json(array('success' => true,'data'=>$post_list));	

    		
    	}

    }

    public function getCampaignList(){

		return view('backend.campaign.list');

    }


	public function getCampaignBasic($id=0){

		$page=Page::pluck('name', 'page_id');

		$post=Post::orderBy('created_at','DESC')->pluck('message', 'post_id');



		// Api::init(env('FACEBOOK_APP_ID'),env('FACEBOOK_APP_SECRET'),Auth::user()->access_token);

		// $result = TargetingSearch::search(
		//   TargetingSearchTypes::GEOLOCATION,
		//   null,
		//   'my',
		//   array(
		//     'location_types' => array('geoip_country_code3_by_name(hostname)'),
		//   ));

		

		return view('backend.campaign.basic',compact('page','post'));

	}

	
	public function getCampaignBasicc(){

		Api::init(env('FACEBOOK_APP_ID'),env('FACEBOOK_APP_SECRET'),Auth::user()->access_token);

	}


    public function postCampaignBasic(Request $request){


    	Api::init(env('FACEBOOK_APP_ID'),env('FACEBOOK_APP_SECRET'),Auth::user()->access_token);

    	$account = (new AdAccount(Auth::user()->ads_id))->read(array(
			AdAccountFields::ID,
			AdAccountFields::NAME,
			AdAccountFields::ACCOUNT_STATUS,
		));




		/* Creating the CAMPAIGN */


		try{

		    $campaign  = new Campaign(null, $account->id);

		    $campaign->setData(array(

		        CampaignFields::NAME =>$request->campaign_name,
		        CampaignFields::OBJECTIVE =>$request->objective,
		    ));

		    $campaign->validate()->create(array(
		        Campaign::STATUS_PARAM_NAME => Campaign::STATUS_ACTIVE,
		    ));

		    echo "Campaign ID:" . $campaign->id . "\n";
		}

		catch (Exception $e) {
		    echo 'Error message: ' .$e->getMessage() ."\n" . "<br/>";
		    echo 'Error Code: ' .$e->getCode() ."<br/>";
		}

		/* TARGETING */

		$targeting = new Targeting();

		$targeting->setData(array(
		    TargetingFields::GEO_LOCATIONS => array(
		        'countries' => array($request->countries),
		    ),
		    TargetingFields::GENDERS => array($request->gender),
		    TargetingFields::AGE_MIN=>$request->min_age,
		    TargetingFields::AGE_MAX=>$request->max_age,
		));

		/**
		 * Step 4 Create the AdSet
		 */


		try{

			/* CALC TIME */

			if($request->budget_type==20){/*IF LIFE TIME */

				
				$start_time=$request->start_date."T".date('H:i:s',strtotime($request->start_time))."+0600";

				$end_time=$request->end_date."T".date('H:i:s',strtotime($request->end_time))."+0600";


			}else{

				if($request->schedule==20){

					$start_time=$request->start_date."T".date('H:i:s',strtotime($request->start_time))."+0600";

					$end_time=$request->end_date."T".date('H:i:s',strtotime($request->end_time))."+0600";

				}else if($request->schedule==10){

					$start_time=$request->start_date."T".date('H:i:s',strtotime(date('Y-m-d')))."+0600";


				}


			}

		    $adset = new AdSet(null, $account->id);


		    if($request->schedule==10){/* If Dailly Budget */


		    	$adset->setData(array(

			        AdSetFields::NAME =>$request->adset_name,
			        AdSetFields::CAMPAIGN_ID => $campaign->id,
			        AdSetFields::DAILY_BUDGET => $request->budget*100,
			        AdSetFields::TARGETING => $targeting,
			        AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::POST_ENGAGEMENT,
			        AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
			        AdSetFields::IS_AUTOBID=>true,
			        AdSetFields::START_TIME =>$start_time,
			        
			    ));

		    }else{

		    	$adset->setData(array(

			        AdSetFields::NAME =>$request->adset_name,
			        AdSetFields::CAMPAIGN_ID => $campaign->id,
			        AdSetFields::DAILY_BUDGET => $request->budget*100,
			        AdSetFields::TARGETING => $targeting,
			        AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::POST_ENGAGEMENT,
			        AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
			        AdSetFields::IS_AUTOBID=>true,
			       
			        AdSetFields::START_TIME =>$start_time,
			        AdSetFields::END_TIME =>$end_time,
			    	));
		    }

		    



		    $adset->validate()->create(array(
		        AdSet::STATUS_PARAM_NAME => AdSet::STATUS_ACTIVE,
		    ));



		    echo 'AdSet  ID: '. $adset->id . "\n";
		}

		catch (Exception $e) {

		    echo 'Error message: ' .$e->getMessage() ."\n" . "<br/>";
		    echo 'Error Code: ' .$e->getCode() ."<br/>";
		}

		
		/**
		 * Step 5 Create an AdImage
		 */


		try {
		    $image = new AdImage(null, $account->id);
		    $image->{AdImageFields::FILENAME}
		        = public_path().'/image.png';

		    $image->create();
		    echo 'Image Hash: '.$image->hash . "\n";
		}
		catch (Exception $e) {
		    echo 'Error message: ' .$e->getMessage() ."\n" . "<br/>";
		    echo 'Error Code: ' .$e->getCode() ."<br/>";
		}

		/**
		 * Step 6 Create an AdCreative
		 */


		$link_data = new AdCreativeLinkData();

		$link_data->setData(array(

			AdCreativeLinkDataFields::MESSAGE => 'try it out',
		  	AdCreativeLinkDataFields::LINK => 'http://www.google.com/',
		  	AdCreativeLinkDataFields::IMAGE_HASH =>$image->hash,

		));


		$object_story_spec = new AdCreativeObjectStorySpec();

		$object_story_spec->setData(array(
			AdCreativeObjectStorySpecFields::PAGE_ID =>$request->page_id,
		  	AdCreativeObjectStorySpecFields::LINK_DATA => $link_data,
		));
		

		try{
		    
		    $creative = new AdCreative(null, $account->id);

		    $creative->setData(array(
		        AdCreativeFields::NAME =>$request->ad_name,
		        AdCreativeFields::OBJECT_STORY_ID =>$request->post_id,
		    ));

		    $creative->create();
		    echo 'Creative ID: '.$creative->id . "\n";
		}
		catch (Exception $e) {
		    echo 'Error message: ' .$e->getMessage() ."\n" . "<br/>";
		    echo 'Error Code: ' .$e->getCode() ."<br/>";
		}

		/**
		 * Step 7 Create an Ad
		 */

		try {

		    $ad = new Ad(null, $account->id);

		    $ad->setData(array(

		        AdFields::CREATIVE =>
		            array('creative_id' => $creative->id),
		        AdFields::NAME =>$request->ad_name,
		        AdFields::ADSET_ID => $adset->id,
		 
		    ));



		    $ad->create(array(
  				Ad::STATUS_PARAM_NAME => Ad::STATUS_PAUSED,
			));

		    echo 'Ad ID:' . $ad->id . "\n";
		}
		catch (Exception $e) {
		    echo 'Error message: ' .$e->getMessage() ."\n" . "<br/>";
		    echo 'Error Code: ' .$e->getCode() ."<br/>";
		}

    }
}
