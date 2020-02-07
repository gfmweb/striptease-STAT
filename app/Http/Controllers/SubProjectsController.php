<?php

namespace App\Http\Controllers;

use App\SubProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubProjectsController extends Controller
{
	public function list(Request $request)
	{
		$cityIds = $request->get('cityIds');

		SubProject::$listForSelectField = 'fullName';

		$list = SubProject::listForSelect(function (Builder $query) use ($cityIds) {
			$query->with('project');
			if ($cityIds) {
				$query->whereIn('city_id', $cityIds);
			}
		});

		return response()->json($list);
	}

}
