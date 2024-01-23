<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {

	Route::get('/auth/callback', function () {
		$oauth_user = \Laravel\Socialite\Facades\Socialite::driver('azure')->user();
		// $user = (object)[
		// 	'id' => $oauth_user->getId(),
		// 	'name' => $oauth_user->getName(),
		// 	'email' => $oauth_user->getEmail(),
		// 	'principalName' => $oauth_user->user['userPrincipalName'] ?? null,
		// 	'bannerUsername' => explode('@', ($oauth_user->user['userPrincipalName'] ?? null))[0] ?? null,
		// 	'token' => $oauth_user->token,
		// ];

		$user = [
			'id' => $oauth_user->getId(),
			'name' => $oauth_user->getName(),
			'email' => $oauth_user->getEmail(),
			'principalName' => $oauth_user->user['userPrincipalName'] ?? null,
			'bannerUsername' => explode('@', ($oauth_user->user['userPrincipalName'] ?? null))[0] ?? null,
			'token' => $oauth_user->token,
		];

		$userModel = new \App\Models\User();
		$userModel->unguard();
		$userModel->fill([
			'id' => $oauth_user->getId(),
			'name' => $oauth_user->getName(),
			'email' => $oauth_user->getEmail(),
			'principalName' => $oauth_user->user['userPrincipalName'] ?? null,
			'bannerUsername' => explode('@', ($oauth_user->user['userPrincipalName'] ?? null))[0] ?? null,
			'token' => $oauth_user->token,
		]);

		session()->put('user', $userModel);
		session()->put('user-raw', (object)$user);

		return redirect(session()->get('sso_redirect_url') ?? '/');
	});


	Route::get('logout', function () {
		//  Auth::guard()->logout();
		session()->flush();
		$azureLogoutUrl = \Laravel\Socialite\Facades\Socialite::driver('azure')->getLogoutUrl(route('postLogout'));
		return redirect($azureLogoutUrl);
	});

	Route::get('postLogout', function () {
		// Ideally you would build a styled logout page
		return 'You have successfully logged out';
	})->name('postLogout');
});
