<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectDataController extends Controller
{
    public function index()
    {
        // вывод списка заполненных недель
    }

    public function create(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateTo   = $request->get('dateTo');

        if (empty($dateFrom) || empty($dateTo)) {
            return view('project-data.create');
        }

        return view('project-data.create', ['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
