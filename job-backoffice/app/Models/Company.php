<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    // protected $table = 'companies';

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'owner_id',
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

    public function owner() {
        return $this->BelongsTo(User::class, 'owner_id', 'id');
    }

    public function jobVacancies() {
        return $this->hasMany(JobVacancy::class, 'company_id', 'id');
    }
}
