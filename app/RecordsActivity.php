<?php

namespace App;
use Illuminate\Support\Arr;



trait RecordsActivity 
{

    public $oldAttributes = [];



    public static function bootRecordsActivity()
    {
        static::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        $recordableEvents = ['created', 'updated', 'deleted'];

        foreach ($recordableEvents as $event)  {
            static::$event(function ($model) use ($event) {
                if(class_basename($event) !== 'Project') {
                    $event = "{$event}" . strtolower(class_basename($model));
                }

                $model->recordActivity($event);
            });
        }
    }

  
    public function recordActivity($description)
    {
        
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
        
    }




    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();// subject kolona koju gleda, gledace i subject_id i subject_type jer je morph
    }






    protected function activityChanges()
    {
        if($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }        
    }
}