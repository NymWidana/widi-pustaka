<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    // add properties to be filled by accessors
    protected $appends = ['book_ids'];

    // defining which database table is connected
    protected $table = 'categories';

    // defining which attributes can be mass assigned
    protected $fillable = [
        'name'
    ];

    // define the many to many relationship between books and categories
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    // Accessors
    public function getBookIdsAttribute()
    {
        return $this->books->pluck('id');
    }
}
