<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationsRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitationsRequest $request)
    {
        $this->authorize('update', $project);

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
