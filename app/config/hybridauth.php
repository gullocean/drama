<?php
return array(	
	"base_url"   => url() . '/social/auth',
	"providers"  => array (
		"Google"     => array (
			"enabled"    => true,
			"keys"       => array ( "id" => env('GOOGLE_ID'), "secret" => env('GOOGLE_SECRET') ),
			"scope"      => "https://www.googleapis.com/auth/userinfo.profile ".
                            "https://www.googleapis.com/auth/userinfo.email"   ,
			),
		"Facebook"   => array (
			"enabled"    => true,
			"keys"       => array ( "id" => env('FACEBOOK_ID'), "secret" => env('FACEBOOK_SECRET') ),
			'scope'      =>  'email',
			),
		"Twitter"    => array (
			"enabled"    => true,
			"keys"       => array ( "key" => env('TWITTER_ID'), "secret" => env('TWITTER_SECRET') )
			)
	),
);