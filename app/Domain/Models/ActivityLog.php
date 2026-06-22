<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['candidate_id', 'user_id', 'action', 'details'];
    protected $casts = ['details' => 'array'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
