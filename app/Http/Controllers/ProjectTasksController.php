<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {

        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        
        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }






    public function update(Project $project, Task $task)
    {
        
        $this->authorize('update', $task->project);

        $attributes = request()->validate(['body' => 'required']);

        $task->update($attributes);


        // $method = request('completed') ? 'complete' : 'incomplete';

        // $task->$method();

        //ILI

        // if(request('completed')) {
        //     $task->complete();
        // } else {
        //     $task->incomplete();
        // }

        //ILI

        request('completed') ? $task->complete() : $task->incomplete();

        

        return redirect($project->path());

    }
}
