<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 20/08/2018
 * Time: 08:28
 */

namespace App;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        // find event, listen for each one, and record the activity
       foreach(static::getActivitiesToRecord() as $event) {
           static::$event(function ($model) use ($event) {
               $model->recordActivity($event);
           });
       };

       // listen for when is deleteing a record that thread is associated with, then delete activity
        static::deleting(function($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
        // return ['created', 'deleted'];
    }

    /**
     * @param $event
     * @throws \ReflectionException
     */
    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    public function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

}