<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function show(Project $project)
    {
        if (auth()->id() != $project->owner_id) {
            abort(403);
        }
        return view('projects.show', [
            'project' => $project,
        ]);
    }


    public function store()
    {

        $atr = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        auth()->user()->projects()->create($atr);
        /*  $atr['owner_id'] = auth()->id();
          Project::create($atr);*/
        return redirect('/projects');
    }
}
