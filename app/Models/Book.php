<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    // defining which database table is connected
    protected $table = 'books';

    // defining which attributes can be mass assigned
    protected $fillable = [
        'title',
        'description'
    ];

    // define the many to many relationship between authors and books
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    // define the many to many relationship between books and categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
