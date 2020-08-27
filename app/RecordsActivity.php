<?php
/**
 * Created by PhpStorm.
 * User: jit
 * Date: 09/07/2020
 * Time: 05:33 م
 */

namespace App;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait RecordsActivity
{
    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event == 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * @return array
     */
    protected static function recordableEvents()
    {
        if (isset(static::$recordableEvents))
            return static::$recordableEvents;

        return ['created', 'updated'];
    }

    function activityDescription($description)
    {
        return $description . '_' . Str::lower(class_basename($this));
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id,
            'user_id' => ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function activityChanges()
    {
        if ($this->wasChanged())
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
    }
}