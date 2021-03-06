<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['last_name', 'first_name', 'middle_name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getFioAttribute()
    {
        return $this->last_name .' ' . $this->first_name . ' ' . $this->middle_name ?? '';
    }

}
