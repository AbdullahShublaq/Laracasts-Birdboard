<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    //
    protected $guarded = [];
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean'
    ];
    protected static $recordableEvents = ['created', 'deleted'];

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
        $this->update([
            'completed' => TRUE,
        ]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update([
            'completed' => FALSE,
        ]);

        $this->recordActivity('incompleted_task');
    }

}
