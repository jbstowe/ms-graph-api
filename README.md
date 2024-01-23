# MS GRAPH API PLUGIN

This adds helper methods to call the MS Graph API and installs a middleware/routes to implement MS Authentication

## Installation

You can install the package via composer:

```bash
composer require joeystowe/ms-graph-api
```

## Usage
### SSO Authentication
---
The plugin installs a middleware ('ms-auth') and 2 routes (/auth/callback and /logout). To protect a route with authentication you must apply the middleware to the desired routes and set your env variables

#### Apply middleware example
```php
Route::get('/', function () {
    return view('welcome');
})->middleware('ms-auth');
```
Or use middleware groups
```php
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
});
```

> [!CAUTION]
> You can not add the middleware globally or in the web group because the auth callback method needs to be publicy accessible

#### Set you .env variables
```php
// services.php
...
'azure' => [
	'client_id' => env('AZURE_CLIENT_ID'),
	'client_secret' => env('AZURE_CLIENT_SECRET'),
	'tenant' => env('AZURE_TENANT_ID')
	'redirect' => env('AZURE_REDIRECT_URI'),
],
...
```
```env
// .env
...
AZURE_CLIENT_ID=<YOUR CLIENT ID>
AZURE_CLIENT_SECRET=<YOUR CLIENT SECRET>
AZURE_REDIRECT_URI=http://localhost:8080/auth/callback
AZURE_TENANT_ID=<YOUR TENANT ID>
...
```

#### Access the user

```php
dd(Joeystowe\MsGraphApi\LoggedInUser::user());

//Returns an instance of \App\Models\User with the following attributes set from the SSO response
// 	   "id" => "ms user id"
//     "name" => "Full Name"
//     "email" => "User's email"
//     "principalName" => "User's Principal Name"
//     "bannerUsername" => "User's banner username"
//     "token" => "token_value"
```
If you prefer not to use an instance of the User model you can call:
```php
//Returns an object with the same properties as above set
dd(Joeystowe\MsGraphApi\LoggedInUser::userRaw());
```


### Calling Graph API
---
The plugin also gives you helper methods to call the MS graph API
#### Logged In User Methods
##### Groups
```php
$user = Joeystowe\MsGraphApi\LoggedInUser::user();
//resolve instance of current user API
$graphApi = app(Joeystowe\MsGraphApi\MsGraphCurrentUserApi::class, ['token' => $user->token]);

//Get all user's groups, returns array of groups
$graphApi->groups()

//Check if a user is in a specific group, returns boolean
$graphApi->inGroup(groupId: $groupIdToCheck)
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

-   [Joey Stowe](https://github.com/joeystowe)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


