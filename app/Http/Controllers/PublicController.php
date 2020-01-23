<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LiqPay;

class PublicController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('welcome');
	}

}
