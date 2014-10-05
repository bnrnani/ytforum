<?php

class UserController extends BaseController
{

protected $layout = 'layouts.master';

	public function getCreate()
	{
		return View::make('user.register');
	}

	public function getLogin()
	{
		return View::make('user.login');
	}
	
	public function postCreate()
	{
		$validate = Validator::make(Input::all(), array(
			'username' => 'required|unique:users|min:4',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1'
		));

		if ($validate->fails())
		{
			return Redirect::route('getCreate')->withErrors($validate)->withInput();
		}
		else
		{
		
			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('pass1'));
			$user->remember_token = 0;

			if ($user->save())
			{
				//Session::put('success', 'Your Registerd Succesfully, You Can Login');
				return Redirect::route('home')->with('success', 'You Registerd Succesfully, You Can Login');
			}
			else
			{
				return Redirect::route('home')->with('fail', 'Error Occured');
			}
		}
	}


	public function postLogin()
	{
			$validator = Validator::make(Input::all(),array(
				'username' => 'required',
				'pass1' => 'required',
			));

		if($validator->fails())
		{
			return Redirect::route('getLogin')->withErrors($validator)->withInput();
		}
		else
		{
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
					'username' => Input::get('username'),
					'password' => Input::get('pass1'),
			), $remember);

			if($auth)
			{
				return Redirect::intended('/');
			}
			else
			{
				return Redirect::route('getLogin')->with('fail', 'Please try again');
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}
}