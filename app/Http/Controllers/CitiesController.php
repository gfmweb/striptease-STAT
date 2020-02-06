<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
	public function list(Request $request)
	{
		$list = City::listForSelect();

		return response()->json($list);
	}

}
