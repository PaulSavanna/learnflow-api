<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'user_id', 'body'];

    protected static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
