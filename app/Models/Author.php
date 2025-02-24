<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    // defining which database table is connected
    protected $table = 'authors';

    // defining which attributes can be mass assigned
    protected $fillable = [
        'name'
    ];

    // define the many to many relationship between authors and books
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
