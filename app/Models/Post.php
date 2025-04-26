<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['author_id', 'title', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
