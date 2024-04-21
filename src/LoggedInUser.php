<?php

namespace Joeystowe\MsGraphApi;

class LoggedInUser
{
	/**
	 * Get the current user from the session
	 *
	 * @return object
	 */
	public static function user()
	{
		return session('ms:user');
	}

	/**
	 * Get the current user from the session as an array
	 *
	 * @return array
	 */
	public static function userArray()
	{
		return (array)session('ms:user');
	}

	/**
	 * Get the current user from the session as a model
	 * 
	 * @return \App\Models\User
	 */
	public static function userModel()
	{
		$userModel = new \App\Models\User();
		$userModel->unguard();
		$userModel->fill((array)session('ms:user'));

		return $userModel;
	}

	/**
	 * Get a specific attribute from the current user
	 * 
	 * @param string $attribute
	 * @return mixed
	 */
	public static function userAttribute($attribute)
	{
		return session('ms:user')->$attribute;
	}
}
