<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'url',
        'source',
        'published_at',
        'summary',
        'topic_id',
        'image_url'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Each article belongs to a topic
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // Each article can have many user interactions
    // public function interactions()
    // {
    //     return $this->hasMany(UserArticleInteraction::class);
    // }
}
