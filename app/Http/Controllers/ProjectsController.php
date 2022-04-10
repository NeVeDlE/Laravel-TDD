<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->projects
        ]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }


    public function store()
    {

        $atr = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3',
        ]);
        $project = auth()->user()->projects()->create($atr);
        /*  $atr['owner_id'] = auth()->id();
          Project::create($atr);*/
        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update([
            'notes' => request('notes')
        ]);
        return redirect($project->path());
    }
}
