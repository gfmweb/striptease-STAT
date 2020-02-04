<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
	public function index()
	{
		$partners = User::where('role', 1)->get();

		return view('partners.index')->with(['partners' => $partners]);
	}

	public function edit($id)
	{
		$partner  = User::query()->findOrFail($id);
		$partners = User::all()->pluck('name', 'id')->toArray();
		$partners = ['' => 'Укажите партнера'] + $partners;

		return view('partners.edit')->with(['partner' => $partner, 'partners' => $partners]);
	}

	public function create()
	{
		$partner  = new User();
		$partners = User::all()->pluck('name', 'id')->toArray();
		$partners = ['' => 'Укажите канал'] + $partners;

		return view('partners.create')->with(['partner' => $partner, 'partners' => $partners]);
	}

	public function update(Request $request, $id)
	{
		$partner = User::query()->findOrFail($id);
		$partner->fill($request->all());
		$partner->save();

		\Flash::success('Партнер успешно изменен');

		return redirect()->route('partners.index');
	}


	public function store(Request $request)
	{
		$partner = new User();
		$partner->fill($request->all());
		$partner->save();

		\Flash::success('Партнер успешно создан');

		return redirect()->route('partners.index');
	}

	public function destroy($id)
	{
		$partner = User::query()->findOrFail($id);
		$partner->delete();

		\Flash::success('Партнер успешно удален');

		return redirect()->route('partners.index')->getTargetUrl();
	}

}
