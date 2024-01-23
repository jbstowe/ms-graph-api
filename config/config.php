<?php

/*
 * You can place your custom package configuration in here.
 */
return [
	'azure' => [
		'client_id' => env('AZURE_CLIENT_ID'),
		'client_secret' => env('AZURE_CLIENT_SECRET'),
		'redirect' => env('AZURE_REDIRECT_URI'),
		'tenant' => env('AZURE_TENANT_ID'),
		'proxy' => env('PROXY')  // optionally
	],
];
