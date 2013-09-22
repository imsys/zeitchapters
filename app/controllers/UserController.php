<?php

class UserController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('isadmin');
	}

	public function index()
	{
		$users = User::all();
		return View::make('user.list')
			->with('users', $users);
	}

	public function get_new()
	{
		$roles = Role::all();
		return View::make('user.new')
			->with('roles', $roles);
	}

	public function post_new()
	{
		
		$rules = array(
			'name'  => 'required|max:120',
			'email' => 'required|email|unique:users',
			'password' => 'required',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('user/new')
					->withErrors($validation)
					->withInput(Input::except('password'));
		}

		$user = array(
			'name'     => Input::get('name'),
			'email'      => Input::get('email'),
			'password' => Input::get('password')
		);

		$user['password'] = Hash::make(Input::get('password'));

		$user = new User($user);
		$user->save();

		return Redirect::to('user');
	}

	public function get_edit($id)
	{
		$user = User::find($id);
		$roles = Role::all();
	//	return print_r($user->to_array());
		return View::make('user.new')
			->with('roles', $roles)
			->with('user',$user);
	}


	public function post_edit($id)
	{
		$user = User::find($id);
		if(!$user){return 'User not found';}
		
		$rules = array(
			'name'  => 'required|max:120',
			'email' => 'required|email|unique:users,email,'.$user->id,
			//'password' => 'required',
		);

		$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
		{
			return Redirect::to('user/'.$id.'/edit')
					->withErrors($validation)
					->withInput(Input::except('password'));
		}

		$user = User::find($id);

		
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		if(Input::get('password')){
			$user->password = Hash::make(Input::get('password'));
		}
		
		if (Input::get('role') == 1){
			if(!$user->has_role('admin')){
				$user->roles()->attach(1);
			}
		} elseif($user->has_role('admin')){
			$user->roles()->detach(1);
		}

		$user->save();

		return Redirect::to('user');
	}

}