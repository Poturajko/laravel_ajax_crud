<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'published_at','is_published'];

    public function authors()
    {
        return $this->belongsToMany(Author::class)->withTimestamps();
    }

}
