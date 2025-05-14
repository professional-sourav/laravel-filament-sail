<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'task_id',
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(self::class, 'task_id');
    }
}
