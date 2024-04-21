<?php

namespace Joeystowe\MsGraphApi\Http\Middleware;

use Closure;

class MicrosoftAuthMiddleware
{
	public function handle($request, Closure $next)
	{
		// Perform action
		if (!session('ms:user')) {
			session()->flash('sso_redirect_url', url()->current());
			return \Laravel\Socialite\Facades\Socialite::driver('azure')->redirect();
		}

		return $next($request);
	}
}
