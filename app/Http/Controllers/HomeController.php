<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;


class HomeController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return redirect()->route('project-data.create');//view('home' );
	}

}
