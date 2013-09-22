<?php
use Symfony\Component\Security\Core\Util\SecureRandom;


use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;


class RegistrationController extends BaseController {

    
	public function __construct()
	{
		$this->beforeFilter(function()
		{
			//remove filter
		});
		
		 $this->beforeFilter('csrf', array('only' =>
                            array('postIndex')));


	}
	
	public function getIndex()
	{
		return Redirect::to('registration/facebook');
	//	return View::make('pages.registration');
			
	}
	
/*	public function postIndex(){
			
		$rules = array(
			'name'  => 'required|min:3|max:120',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|max:120',
			'password_confirm' => 'required|same:password',
			'captcha' => 'required|captcha',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('registration')
					->withErrors($validation)
					->withInput(Input::except('password','password_confirm'));
		}
		$inpt = Input::all();
		
		$inpt['password'] = Hash::make($inpt['password']);
		unset($inpt['password_confirm']);
		
		$redis = Redis::connection();
		//if(!$redis) return 'Problems connecting with the index server database';
		while(true){
			$enc = bin2hex(openssl_random_pseudo_bytes(16));
			$key = 'registration:'.$enc;
			if ($redis->get($key)) continue;
			$redis->set($key, json_encode($inpt));
			$redis->expire($key,60*60*48); //expira em 2 dias
			break;
		}
		Session::put('_token', sha1(microtime()));//replace token, so user doesn't resend form by refreshing page
		$inpt['enc'] = $enc;
		Mail::send('emails.auth.registration', $inpt, function($message) use ($inpt)
		{
			$message->to($inpt['email'], $inpt['name'])->subject('Bem Vindo - Cadastro Movimento Zeitgeist');
		});

		//return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Por favor, veja o email que enviamos para completar o registro.'));
		return Redirect::to('registration/almostdone');
	}*/
	
	
public function getFacebook()
{
	$okey = Session::get('regist_oauth');
	if($okey){
	//	return var_dump($okey);
		return View::make('registration.facebook')
				->with('okey',$okey);
	}
	
	return $this->getOauth('facebook');
	
}

public function postFacebook()
{
	$okey = Session::get('regist_oauth');
	if($okey){
		$rules = array(
			'name'  => 'required|min:3|max:120',
			'email' => 'required|email|unique:users',
			'fbid' => 'required|unique:fbid',
		);
		
		$userk = array(
			'name'     => $okey['name'],
			'email'    => $okey['email'],
			'fbid'    => $okey['uid'],
			'fblink'    => $okey['urls']['Facebook'],
		);
				
		$validation = Validator::make($userk, $rules);
		
		//$redis->del($key);	//we don't want to use this key again.
		
		if(!$validation || User::where('email', '=', $okey['email'])->first()){return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Algum erro ocorreu. É provavel que você ja esteja cadastrado.'));}
		if(!$userk['email']){return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Erro. Por alguma razão desconhecida o Facebook não forneceu seu email.'));}
		if(!$userk['fbid']){return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Erro. Por alguma razão desconhecida o Facebook não forneceu seu email.'));}

		$user = new User($userk);
		$user->save();
		
		$user = User::where('email', '=', $okey['email'])->first();
		
		$user->set_role_on_chapter('member', 1); //subscribe to world
		Chapter::find(1)->UpdateAnalyticsMembership();
		
		$chapters = Input::get('chapter');
		
		foreach ($chapters as $value){
			$chap = Chapter::find($value);
			if(!$chap){continue;}
			$user->set_role_on_chapter('member', $value);
			$user->subscriptions()->attach($value);
			$chap->UpdateAnalyticsMembership();
			$chap->UpdateAnalyticsSubscriptions();
		}
		
		
				
		Auth::login($user);
		//return Redirect::to('chapter/view/1');
		
		return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Você está agora registrado em nosso sistema. :) <br /> Enviaremos emails informando sobre o que está acontencendo em seu capítulo. <br /><b> '.link_to('chapter/view/1', 'Acessar sistema.').'</b>'));

		
		
		//return View::make('registration.facebook')
		//		->with('okey',$okey);
	}
	
	return 'erro';
	
}

	
	
	private function getOauth($provider)
{
		//return $provider;
	
		
	//return 'ók';
	//$provider ='facebook';
    $provider = OAuth2::provider($provider, Config::get('oauth.facebook'));

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
				Session::forget('regist_oauth');
				Session::put('regist_oauth', $user);
				return Redirect::to('registration/facebook');

				//return View::make('registration.facebook');
			}
				
				
				
			
        }

        catch (OAuth2_Exception $e)
        {
            show_error('That didnt work: '.$e);
        }
    }
	
	
	
		//Session::put('ab', 'shit');
		
		
		
		
}
	
	
	public function getAlmostdone(){
		return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Por favor, veja o email que enviamos para completar o registro.'));
	}
	
	
	public function postListSubchapters($id){
		if (!$id){return;}
		$chapter = Chapter::where('parent_id', '=', $id)->orderBy('name')->get(array('id','name'));
		return $chapter; //Json reply
				
	}
	
	
	public function getConfirm($id){
			
		$key = 'registration:'.$id;
		
		$redis = Redis::connection();

		$r = json_decode($redis->get($key));
		
		if(!$r) { return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Chave expirada, por favor se registre novamente.'));}
		
		
		$rules = array(
			'name'  => 'required|min:3|max:120',
			'email' => 'required|email|unique:users',
		);
		
		$userk = array(
			'name'     => $r->name,
			'email'    => $r->email,
			'password' => $r->password
		);
				
		$validation = Validator::make($userk, $rules);
		
		$redis->del($key);	//we don't want to use this key again.
		
		if(!$validation){return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Algum erro ocorreu. Tente se recadastrar.'));}
		

		$user = new User($userk);
		$user->save();
		
		$user = User::where('email', '=', $r->email)->first();
		
		$user->set_role_on_chapter('member', 1); //subscribe to world
		Chapter::find(1)->UpdateAnalyticsMembership();
		
		foreach ($r->chapter as $value){
			$chap = Chapter::find($value);
			if(!$chap){continue;}
			$user->set_role_on_chapter('member', $value);
			$user->subscriptions()->attach($value);
			$chap->UpdateAnalyticsMembership();
			$chap->UpdateAnalyticsSubscriptions();
		}
		
		
		return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Você está agora registrado em nosso sistema. :) <br /> Enviaremos emails informando sobre o que está acontencendo em seu capítulo.'));
	}
	

}