<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUpdateRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Project as ReflectionProject;

class ProjectsController extends Controller
{

    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }


    public function show(Project $project)
    {
        

        // if(auth()->user()->isNot($project->owner)) {
        //     abort(403);
        // }

        //Ovo iznad samo sa pravljenjem policy
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }



    public function create()
    {
        return view('projects.create');
    }



    public function store()
    {

        $attributes = $this->validateRequest();


        // $attributes['owner_id'] = auth()->id();//ovo dole menja ovu liniju

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }



    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }



    public function update(Project $project)
    {
        

        // $project->update([
        //     'notes' => request('notes'),
        // ]);

        // $project->update($request->validated());

        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }


    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
