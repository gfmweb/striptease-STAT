<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Password;
use App\PasswordCity;


class PasswordCityController extends Controller
{

	public function create(Request $request, $project_id)
	{
		$passwordCity = new PasswordCity();
		$passwordCity->password_id = $project_id;
		$passwordCity->city_id    = $request->get('city_id');
		$passwordCity->save();

		\Flash::success('Город добавлен');

		return redirect()->back();
	}

	/*public function index()
	{
		$passwords = Password::all();

		return view('passwords.index')->with([
			'passwords' => $passwords,
		]);
	}

	public function store(Request $request)
	{
		$password = new Password();
		$password->fill($request->all());
		$password->save();

		\Flash::success('Пароль успешно создан');

		return redirect()->route('passwords.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$password = Password::query()->findOrFail($id);
		$cities   = City::all();

		return view('passwords.edit')->with([
			'password' => $password,
			'cities'   => $cities,
		]);
	}

	public function update(Request $request, $id)
	{
		$password = Password::query()->findOrFail($id);
		$password->fill($request->all());
		$password->save();

		\Flash::success('Пароль изменен');

		return redirect()->route('passwords.index');
	}

	public function destroy($id)
	{
		$password = Password::query()->findOrFail($id);
		$password->delete();

		\Flash::success('Пароль удален');

		return redirect()->route('passwords.index')->getTargetUrl();
	}*/
}
