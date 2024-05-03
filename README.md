# MS GRAPH API PLUGIN

This adds helper methods to call the MS Graph API and installs a middleware/routes to implement MS Authentication

## Installation

You can install the package via composer:

```bash
composer require joeystowe/ms-graph-api:dev-main
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
Route::middleware('ms-auth')->group(function () {
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
	'tenant' => env('AZURE_TENANT_ID'),
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

#### Accessing the user
The ms-auth middleware sets the following __scoped__ session values

```php
session()->put('ms:user', (object)$user);
session()->put('ms:username', $user['bannerUsername']);
session()->put('ms:email', $user['email']);
session()->put('ms:principalName', $user['principalName']);
session()->put('ms:id', $user['id']);
session()->put('ms:session-token', $user['token']);
```

You can reference these directly or you can use the __LoggedInUser__ helper class:

```php
// Returns an object with the following properties set
Joeystowe\MsGraphApi\LoggedInUser::user();
{
  "id" => "1111-2222-33333-44444" //ms user id
  "name" => "John Doe" //Full Name
  "email" => "john.doe@eng.ua.edu"
  "principalName" => "jdoe@ua.edu"
  "bannerUsername" => "jdoe"
  "token" => "1111-2222-3333-4444" //ms session token
}

//Fetch users properties as an array
Joeystowe\MsGraphApi\LoggedInUser::userArray();

//Fetch users properties as a pre-filled User model
Joeystowe\MsGraphApi\LoggedInUser::userModel();

//Fetch a single user attribute (throws exception is property is not found)
Joeystowe\MsGraphApi\LoggedInUser::userAttribute('principalName')
//returns "jdoe@ua.edu"
```



#### Logging Out
Simply hit the '/logout' route to log the user out. After logging out from MS the user will be redirected to a '/postLogout' page. Be sure to set your APP_URL correctly so the "log back in" url will work correctly.

You will also need to publish the assets for the postLogout page to be fully functional:
```bash
php artisan vendor:publish --tag=assets --ansi --force
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


