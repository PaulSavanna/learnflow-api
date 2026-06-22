<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\VacancyFactory;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'created_by'];

    protected static function newFactory(): VacancyFactory
    {
        return VacancyFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
