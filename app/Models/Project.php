<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];


    /*They've changed the date formatting (when using toArray method) in Laravel 7.x.
     The documentation : https://laravel.com/docs/7.x/upgrade#date-serialization

    That's the reason why the date format is different when
     comparing the old and the new one, since the new one using toArray() method.

    So, like the documentation says, you can override the
     serializeDate method on your model (in this case, the Project model) :*/
    /* protected function serializeDate(DateTimeInterface $date)
     {
         return $date->format('Y-m-d H:i:s');
     }*/

    public function path()
    {
        return '/projects/' . $this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create([
            'body' => $body,
            'project_id' => $this->id
        ]);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }


}
