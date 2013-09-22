<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

Route::get('login',function(){
	return View::make('pages.fblogin');
});
/*
Route::post('login', function() {
    $userdata = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
		//TODO: verificar se é usuario comum ou admin
    );
	
    if ( strlen($userdata['password']) > 1 && Auth::attempt($userdata) )
    {
        return Redirect::to('chapter/view/1');
    }
    else
    {
        return Redirect::to('login')
            ->with('login_errors', true);
    }
});*/


Route::get('fblogin',function(){

	$provider = OAuth2::provider('facebook', Config::get('oauth.facebook'));

    if ( ! isset($_GET['code']))
    {
        // By sending no options it'll come back here
        return $provider->authorize();
    }
    else
    {
        // Howzit?
        try
        {
            $params = $provider->access($_GET['code']);

                $token = new Token_Access(array(
                    'access_token' => $params->access_token
                ));
				//return $token;
				
                $user = $provider->get_user_info($token);

            // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
            // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
          //  echo "<pre>";
          //  var_dump($user);

			$userdb = User::where('fbid', '=', $user['uid'])->first();
			if ( $userdb )
			{
				Auth::login($userdb);
				return Redirect::to('chapter/view/1');
			}
			else
			{
				return Redirect::to('registration/facebook');
			}
        }

        catch (OAuth2_Exception $e)
        {
            show_error('That didnt work: '.$e);
        }
    }
	
	
	return Redirect::to('login');
});


Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});


Route::get('/', 'HomeController@index');

Route::get('/chapter/view/{id}', 'ChapterController@view');
Route::any('/chapter/edit/{id}', 'ChapterController@edit');

Route::any('/chapter/users/{id}', 'ChapterController@users');



Route::post('/chapter/membership/{id}', 'ChapterController@membership');
Route::post('/chapter/subscription/{id}', 'ChapterController@subscription');

Route::get('/chapter/requestcoord/{id}', 'ChapterController@getRequestcoord');
Route::post('/chapter/requestcoord/{id}', 'ChapterController@postRequestcoord');

Route::get('/user', 'UserController@index');
Route::get('/user/new', 'UserController@get_new');
Route::post('/user/new', 'UserController@post_new');

Route::get('/user/{id}/edit', 'UserController@get_edit');
Route::post('/user/{id}/edit', 'UserController@post_edit');

Route::controller('profile', 'ProfileController');

Route::controller('registration', 'RegistrationController');

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	if (Auth::guest()) return Redirect::to('login');
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/


