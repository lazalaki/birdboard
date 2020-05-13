
<div class="card shadow" style="height: 200px;">

    <h3 class="font-normal text-xl py-2 -ml-5 border-l-4 border-blue-300 pl-4">
        <a href="{{ $project->path() }}" class="text-black-500 no-underline">{{ $project->title }}</a>
    </h3>

    
    <div class="text-gray-500 mb-4">
        {{ Illuminate\Support\Str::limit($project->description, 100) }}
    </div>

    <footer>
        <form method="POST" action="{{ $project->path() }}" class="text-right">
            @method('DELETE')
            
            @csrf
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>

</div>