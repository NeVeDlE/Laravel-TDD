<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project,
        ]);
    }


    public function store()
    {
        $atr = request()->validate(['title' => 'required',
            'description' => 'required']);
        Project::create($atr);
        return redirect('/projects');
    }
}
