<?php

namespace App\Http\Controllers;

use App\City;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
	public function list(Request $request)
	{
		$list = Tag::listForSelect();

		return response()->json($list);
	}

}
