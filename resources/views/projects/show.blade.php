@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between w-full items-end">
            
            <p class="text-gray-500 text-base font-normal">
                <a href="/projects">My projects</a> / {{ $project->title }}
            </p>
            
            <a href="/projects/create" class="button">New Project</a>

        </div> 

    </header>



    <main>
        <div class="lg:flex -mg-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-500 text-lg font-normal mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)

                        <div class="card shadow mb-3">

                            <form method="POST" action="{{ $task->path() }}">

                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input class="w-full {{ $task->completed ? 'text-gray-500' : ''}}" value="{{ $task->body }}" name="body">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()"  {{ $task->completed ? 'checked' : '' }}>
                                </div>

                            </form>
                        </div>
                        
                    @endforeach

                    <div class="card shadow mb-3">
                        <form method="POST" action="{{ $project->path() . '/tasks'}}">
                            @csrf

                            <input class="w-full" placeholder="Add a new task..." name="body">
                        </form>
                    </div>
                    
                </div>


                <div>
                    <h2 class="text-gray-500 text-lg font-normal mb-3">General Notes</h2>            

                    <textarea class="card shadow w-full" style="min-height: 200px;">Lorem ipsum.</textarea>
                </div>
                
            </div>



            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>






@endsection