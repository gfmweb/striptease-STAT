<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function partnersList(Request $request)
	{
		$cityIds       = $request->get('cityIds');
		$subProjectIds = $request->get('subProjectIds');

		$list = User::listForSelect(function (Builder $query) use ($cityIds, $subProjectIds) {
			$query->where('role', User::ROLE_USER);
			if ($subProjectIds) {
				$query->whereHas('subProjects', function (Builder $query) use ($cityIds) {
					if ($cityIds) {
						$query->whereIn('city_id', $cityIds);
					}
				});
			}
		});

		return response()->json($list);
	}

}
