<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    // protected $table = 'jobapplications';

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'jobVacancy_id',
        'resume_id',
        'user_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

        protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function user() {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
    public function resume() {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }
    public function jobVacancy() {
        return $this->belongsTo(JobVacancy::class, 'jobVacancy_id', 'id');
    }
}
