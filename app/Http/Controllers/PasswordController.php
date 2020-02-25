<?php

namespace App\Http\Controllers;

use App\City;
use App\Password;
use App\Tag;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$passwords = Password::all();

		return view('passwords.index')->with([
			'passwords' => $passwords,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$password  = new Password();
		$passwords = Password::all()->pluck('name', 'id')->toArray();
		$passwords = ['' => 'Укажите Пароль'] + $passwords;
		$tags      = Tag::listForSelect();

		return view('passwords.create')->with([
			'password'  => $password,
			'passwords' => $passwords,
			'tags'      => $tags,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$password = new Password();
		$password->fill($request->all());
		$password->save();

		$password->tags()->sync($request->tags);

		\Flash::success('Пароль успешно создан');

		return redirect()->route('passwords.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$password = Password::query()->findOrFail($id);
		$cities   = City::all();
		$tags     = Tag::listForSelect();

		return view('passwords.edit')->with([
			'password' => $password,
			'cities'   => $cities,
			'tags'     => $tags,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$password = Password::query()->findOrFail($id);
		$password->fill($request->all());
		$password->tags()->sync($request->tags);
		$password->save();

		\Flash::success('Пароль изменен');

		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy($id)
	{
		$password = Password::query()->findOrFail($id);
		$password->delete();

		\Flash::success('Пароль удален');

		return redirect()->route('passwords.index')->getTargetUrl();
	}

	/**
	 * @param Request $request
	 * @param         $passwordId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function addCity(Request $request, $passwordId)
	{
		/** @var Password $password */
		$password = Password::query()->findOrFail($passwordId);
		$cityId   = $request->get('cityId');
		if ($cityId) {
			$password->cities()->attach($cityId);
			\Flash::success('Город добавлен');
		} else {
			\Flash::warning('Не был указан город. Добавление не произведено');
		}

		return redirect()->back();
	}

}
