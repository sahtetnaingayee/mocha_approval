<?php 

	define('ADMIN_PREFIX','admin');

	define("ACTIVE",1);

	define("PHOTO",'10');
	define("VIDEO",'20');

	define("VIA_CLIENT",1);
	define("VIA_ADMIN",2);

	define("REIVEW",10);
	define("APPROVED",20);

	define("PUBLISHED",'10');
	define("SCHEDULED",'20');

	define("SDK_DIR", __DIR__ . '/..'); // Path to the SDK directory

	define("AWARENESS_OBJECTIVE",json_encode(array(

		'BRAND_AWARENESS'=>'Brand Awareness',
		'REACH'=>'Reach',

		)));

	define("COUNTRIES",json_encode(array(

		'MM'=>'Myanmar',

		)));


	define("CONSIDERATION_OBJECTIVE",json_encode(array(

		'POST_ENGAGEMENT'=>'Post Engagement',
		'PAGE_LIKES'=>'Page Likes',
		'EVENT_RESPONSES'=>'Event Responses',
		'APP_INSTALLS'=>'App Installs',
		'VIDEO_VIEWS'=>'Video Views',
		'LEAD_GENERATION'=>'Lead Generation',


		)));
	

	define("CONVERSION_OBJECTIVE",json_encode(array(

		'CONVERSIONS'=>'Conversions',
		'PRODUCT_CATALOG_SALES'=>'Product Catalog Sales',

		)));	


	$min_range = range(13,65);
	$min_result = array_combine($min_range, $min_range);

	$max_result=$min_result;

	// array_push($max_result,"65+");

	define("MIN_AGE", json_encode($min_result));
	define("MAX_AGE", json_encode($max_result));

	define("COUNTRY",json_encode(array(
		'100'=>'Myanmar'
		)));


	define("OPTIMISATION",json_encode(array(

			'post_engagement'=>'Post Engagement',
			'impressions'=>'Impressions',
			'daily_unique_reach'=>'Daily Unique Reach'

		)));





?>