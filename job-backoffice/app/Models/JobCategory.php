<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    // protected $table = 'jobcategories';


    protected $fillable = [
        'name',
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

    public function jobVacancies() {
        return $this->hasMany(JobVacancy::class, 'category_id', 'id');
    }
}
