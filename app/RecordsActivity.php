<?php

namespace App;
use Illuminate\Support\Arr;



trait RecordsActivity 
{

    public $oldAttributes = [];



    public static function bootRecordsActivity()
    {


        foreach (self::recordableEvents() as $event)  {
            static::$event(function ($model) use ($event) {

                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

  
    public function recordActivity($description)
    {
        
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,//ako imas $this->project vrati to a ukoliko nemas vrati samo $this
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




    protected static function recordableEvents()
    {
        if(isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        } 
        
        return ['created', 'updated'];
    }


    protected function activityDescription($description)
    {
            return "{$description}_" . strtolower(class_basename($this));//moze $this jer se metoda zove nad instancom. Ovo daje npr created_task
    }
}