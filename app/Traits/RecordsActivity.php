<?php

namespace App\Traits;

use App\Models\Activity;

trait RecordsActivity
{

    public $oldAttributes = [];

    /**
     * Boot the trait
     */
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

    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * @return string[]
     */
    public static function recordableEvents(): array
    {
        return static::$recordableEvents ?? ['created', 'updated', 'deleted'];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * @param string $type
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->getActivityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id,
        ]);
    }

    protected function getActivityChanges()
    {
        if ($this->wasChanged())
            return [
                'before' => \Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => \Arr::except($this->getChanges(), 'updated_at'),
            ];
    }
}
