<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relationships
     */

    // A topic can have many articles
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // A topic can have many users subscribed (pivot)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_topics')->withTimestamps();
    }
}
