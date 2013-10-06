<?php

class ChapterController extends BaseController {

	//$this->filter('before', 'auth');
	
	public function __construct()
	{
		 $this->beforeFilter('auth');
		 
		 $this->beforeFilter('csrf', array('only' =>
                            array('postRequestcoord')));
		 


	}

	public function index($id)
	{
		if (!$id){$id = 1;}
		
		$chapter = Chapter::find($id);
		
		return View::make('chapter.show')
			->with('chapter', $chapter);
	}


	public function view($id)
	{
		if (!$id){$id = 1;}
		
		$chapter = Chapter::with(array('coordinators'=> function($query)
			{
				$query->where('chapterrole_id', '=', 1); //I should not need to do this :S

			},'subchapters','subchapters.coordinators'=> function($query)
			{
				$query->where('chapterrole_id', '=', 1);

			}))->find($id);
			
		if(!$chapter){
			return View::make('pages.message', array('title' => 'Erro', 'msg'=>'Índice do capítulo incorreto.'));
		}
			
		$usercoordchap = Auth::user()->has_role_on_chapter('Coordinator', $chapter->id) || Auth::user()->has_role_on_chapter('subcoordinator', $chapter->id) || Auth::user()->has_role('admin');
			
		//return print_r($chapter);
		//$subs = $chapter->subchapters;//()->with(array('author', 'author.contacts'))->get();
		//return print_r($subs);

		/*$subchapters = array();
		foreach ($subs as $key => $sub){
			$subchapters[$key] = Chapter::find($sub->id);
		}*/
		//return print_r($chapter->subchapters[0]->coordinators[0]->name);
		return View::make('chapter.show')
			->with('chapter', $chapter)
			//->with('subchapters', $chapter->subchapters)
			->with('usercoordchap', $usercoordchap)
			->with('userrole',Auth::user()->what_role_on_chapter($id));
	}

	public function edit($id)
	{
		if (!$id){return 'error';}
		if(!(Auth::user()->has_role_on_chapter('coordinator', $id) || Auth::user()->has_role_on_chapter('subcoordinator', $id) || Auth::user()->has_role('admin'))){return "Permission Denied";}

		$chapter = Chapter::find($id);
		$subs = $chapter->subchapters;

		if(!Input::has('name')){
			return View::make('chapter.edit')
				->with('chapter', $chapter);
		}

	/*	$chap = array(
			'name'     => Input::get('name')
		);
*/
		$rules = array(
			'name'  => 'required|max:100'
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			$roles = Role::all();

			return View::make('chapter.edit')
				->with('chapter', $chapter)
				->with('errors', $validation->errors);
		}

		$chapter->name = Input::get('name');
		$chapter->name_en = Input::get('name_en');
		$chapter->enabled = Input::get('enabled');
		$chapter->abbr = Input::get('abbr');
		$chapter->website = Input::get('website');
		$chapter->email = Input::get('email');
		$chapter->facebookpage = Input::get('facebookpage');
		$chapter->facebookgroup = Input::get('facebookgroup');
		$chapter->gpluspage = Input::get('gpluspage');
		$chapter->gplusgroup = Input::get('gplusgroup');
		$chapter->twitter = Input::get('twitter');
		$chapter->woied = Input::get('woied');
		$chapter->unlocode = Input::get('unlocode');
		$chapter->localcode = Input::get('localcode');
		
		$chapter->save();

		return Redirect::to('chapter/view/'.$id);
		
	}

	public function users($id) //change on any user
	{
		if (!$id){$id = 1;}
		$chapter = Chapter::find($id);
		
		foreach (Chapterrole::all() as $crole){
			$chaprole[$crole->id] =  trans('chapter.'.$crole->name);
		}
		
		//$usersp = $chapter->users()->pivot();
		$users = $chapter->users;
//return print_r(Auth::user()->has_role_on_chapter('coordinator', $id));
		$caneditrole = Auth::user()->has_role_on_chapter('coordinator', $id) || Auth::user()->has_role_on_chapter('subcoordinator', $id) || Auth::user()->has_role('admin');
	
		if(!$caneditrole){return 'Permission denied!';} //temporally? disables regular users to see members list.

		//Ajax changing values (saving)
		if(Input::get('userid') && Input::get('changerole')){
			if($caneditrole){
				$rolepivot = $chapter->users()->where('user_id', '=', Input::get('userid'))->first()->pivot;
				$rolepivot->chapterrole_id = Input::get('changerole');
				return Response::json($rolepivot->save());
			}
			return 'Permission denied!';

		}

		/*$subchapters = array();
		foreach ($subs as $key => $sub){
			$subchapters[$key] = Chapter::find($sub->id);
		}*/
		//return print_r($chapterrole);

		return View::make('chapter.users')
			->with('chapter', $chapter)
			//->with('subchapters', $subchapters)
			->with('chaprole', $chaprole)
			->with('users', $users)
			->with('caneditrole',$caneditrole);
	}
	
	public function getRequestcoord($id)
	{
		
		if (!$id){$id = 1;}
		//;
		$chapter = Chapter::with(array('parent','parent.coordinators'=> function($query)
			{
				$query->where('chapterrole_id', '=', 1); //I should not need to do this :S

			},'coordinators'=> function($query)
			{
				$query->where('chapterrole_id', '=', 1); //I should not need to do this :S

			}))->find($id);
			
		if(!@$chapter->parent->coordinators[0]->name){
			return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Desculpe, mas é necessário ter um Coordenador Estadual primeiro.'));
		}
			
			
		return View::make('chapter.requestcoord')
			->with('chapter', $chapter);

	}
	
	public function postRequestcoord($id)
	{
		if (!$id){$id = 1;}
		
		
		$rules = array(
			'message'  => 'required|max:100000',
			
			'captcha' => 'required|captcha',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('chapter/requestcoord/'.$id)
					->withErrors($validation)
					->withInput(Input::except('captcha'));
		}
		
		
		
		$chapter = Chapter::with(array('parent','parent.coordinators'=> function($query)
			{
				$query->where('chapterrole_id', '<', 3); //coordinators or subcoordinators

			}))->find($id);
		
		if(!@$chapter->parent->coordinators[0]->name){
			return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Desculpe, mas no momento não existe um coordenador Estadual.'));
		}
		
		$inpt['chapname'] = $chapter->name;
		$inpt['msg'] = Input::get('message');
		$inpt['user'] = Auth::user();
		$inpt['chapter'] = $chapter->parent;
		
		if($chapter->parent->email){ // se o capitulo tiver um email, envia pra ele.
			Mail::send('emails.requestcoord', $inpt, function($message) use ($chapter, $inpt)
			{
				$message->from($inpt['user']->email, $inpt['user']->name);
				$message->to($chapter->parent->email, 'Movimento Zeitgeist - '.$chapter->parent->name)->subject('Requisição de Coordenação - '. $inpt['chapname']);
			});
		}
		
		foreach ($chapter->parent->coordinators as $coord){
			if($chapter->parent->email){ //if the chapter has an email, it will just alert the coordinators
				Mail::send('emails.requestcoordcheck', $inpt, function($message) use ($coord, $inpt)
				{
					$message->to($coord->email, $coord->name)->subject('Requisição de Coordenação - '. $inpt['chapname']);
				});
				
			}
			else{ //if the chapter doesn't have an email, it will email every coordinator
				Mail::send('emails.requestcoord', $inpt, function($message) use ($coord, $inpt)
				{
					$message->setReplyTo($inpt['user']->email, $inpt['user']->name);
					$message->to($coord->email, $coord->name)->subject('Requisição de Coordenação - '. $inpt['chapname']);
				});
			}
		}
		Session::put('_token', sha1(microtime()));//replace token, so user doesn't resend form by refreshing page
			
		return View::make('pages.message', array('title' => 'Sucesso', 'msg'=>'Enviamos sua Requisição, Entraremos em contato.'));
	}


	public function membership($id) //change membership of logged user
	{
		if(!Input::get('action')){return;}
		if (!$id){$id = 1;}

		//Auth::user()->what_role_on_chapter($id);

		if(Input::get('action') == 'remove'){
			$chapter = Auth::user()->chapters()->where('chapter_id', '=', $id)->first();
			if($chapter) {
				if (Chapterrole::find($chapter->pivot->chapterrole_id)->name == 'member')
				{ //you can only remove your membership yourself if you are a member
					$chapter->pivot->delete();
					$chapter->UpdateAnalyticsMembership();
					return Response::json(true);
				}
				else {return Response::json(false);}
			}
			return Response::json(true); //if is not a member already, so it already did it's job

		} else{ //get membership
			Auth::user()->set_role_on_chapter('member', $id);
			Chapter::find($id)->UpdateAnalyticsMembership();
			return Response::json(true);
		}

	}

	public function subscription($id) //change membership of logged user
	{
		if(!Input::get('action')){return;}
		if (!$id){$id = 1;}

		$subscription = Auth::user()->is_subscribed_to($id);

		if(Input::get('action') == 'remove'){
			if ($subscription){
				$subscription->pivot->delete();
				Chapter::find($id)->UpdateAnalyticsSubscriptions();
				return Response::json(true);
			}
			return true; //if if there isn't a subscription, so it already did it's job
		} else{ //subscribe
			if($subscription){
				return true;
			}
			Auth::user()->subscriptions()->attach($id);
			Chapter::find($id)->UpdateAnalyticsSubscriptions();
			return Response::json(true);
		}

	}
	

}