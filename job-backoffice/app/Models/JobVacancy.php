<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    // protected $table = 'jobvacancies';

    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'salary',
        'view_count',
        'company_id',
        'category_id',
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

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function jobCategory() {
        return $this->belongsTo(JobCategory::class, 'category_id', 'id');
    }

    public function jobApplications() {
        return $this->hasMany(JobApplication::class, 'jobVacancy_id', 'id');
    }
}
