<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'published_at',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tag_id)
    {
        return in_array($tag_id, $this->tags->pluck('id')->toArray());
    }
}