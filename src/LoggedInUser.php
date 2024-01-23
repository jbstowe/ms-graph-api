<?php

namespace Joeystowe\MsGraphApi;

class LoggedInUser
{
	public static function user()
	{
		return session('user');
	}

	public static function userRaw()
	{
		return session('user-raw');
	}
}
