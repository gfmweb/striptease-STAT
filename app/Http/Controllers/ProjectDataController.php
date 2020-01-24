<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Project;
use App\ProjectData;
use App\SubProject;
use Illuminate\Http\Request;

class ProjectDataController extends Controller
{
    public function index()
    {
        // вывод списка заполненных недель
    }

    public function create()
    {
        $projects    = Project::all()->toJson();
        $subProjects = SubProject::all()->toJson();
        $channels    = Channel::all()->toJson();

        return view('project-data.create', [
            'projects'    => $projects,
            'subProjects' => $subProjects,
            'channels'    => $channels,
        ]);
    }

    public function list(Request $request)
    {
        $dateFrom     = $request->get('dateFrom');
        $dateTo       = $request->get('dateTo');
        $subProjectId = $request->get('subProjectId');

        $list = collect();

        if ($dateTo && $dateFrom && $subProjectId) {
            $list = ProjectData::query()
                ->where('date_from', $dateFrom)
                ->where('date_to', $dateTo)
                ->where('sub_project_id', $subProjectId)->get()->keyBy('channel_id');
        }

        return response()->json($list);
    }

    public function save(Request $request)
    {
        $list         = $request->get('list', []);
        $dateFrom     = $request->get('dateFrom', '2020-01-13');
        $dateTo       = $request->get('dateTo', '2020-01-19');
        $subProjectId = $request->get('subProjectId', 1);

        foreach ($list as $channelData) {
            $projectData = ProjectData::query()
                ->where('date_from', $dateFrom)
                ->where('date_to', $dateTo)
                ->where('sub_project_id', $subProjectId)
                ->where('channel_id', $channelData['channel_id'])
                ->first();

            if (!$projectData) {
                $projectData                 = new ProjectData();
                $projectData->sub_project_id = $subProjectId;
                $projectData->date_from      = $dateFrom;
                $projectData->date_to        = $dateTo;
                $projectData->channel_id     = $channelData['channel_id'];
            }

            $projectData->coverage    = $channelData['coverage'];
            $projectData->transition  = $channelData['transition'];
            $projectData->clicks      = $channelData['clicks'];
            $projectData->leads       = $channelData['leads'];
            $projectData->activations = $channelData['activations'];
            $projectData->price       = $channelData['price'];


            $projectData->save();
        }

        return response()->json(['status' => 'success']);
    }
}
