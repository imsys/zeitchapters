<?php

class ProfileController extends BaseController {


	/*public function index()
	{
		$users = User::all();
		return View::make('user.list')
			->with('users', $users);
	}
*/

	public function getChangepassword()
	{
		//return var_dump(Session::get('msg'));
		return View::make('profile.changepassword')->with('msg',Session::get('msg'));
	}


	public function postChangepassword()
	{
		
		$rules = array(
			'password'  => 'required',
			'newpassword' => 'required|min:6|max:120',
			'confirmpassword' => 'same:newpassword',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('profile/changepassword')
					->withErrors($validation);
		}

		$user = User::find(Auth::user()->id);

		
		$user->password = Hash::make(Input::get('newpassword'));
		

		$user->save();

		return Redirect::to('profile/changepassword')->with('msg','Senha Alterada com Sucesso!');
	}

}