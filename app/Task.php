<?php

namespace App;

use App\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Task extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $touches = ['project']; // Kad god se task updejtuje promeni se kolona updatade_at i kod njega i kod project-a

    protected $casts = [
        'completed' => 'boolean'
    ];




    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }




    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }



    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('incompleted_task');
    }

}
