<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory; // Увери се, че това е добавено

    protected $fillable = ['name']; // Увери се, че полетата са правилни

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
