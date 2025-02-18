<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factorybooks = Book::factory(100)->create();
        foreach($factorybooks as $factorybook){
            $authors = Author::inRandomOrder()->take(rand(1, 2))->pluck('id');
            $factorybook->authors()->attach($authors);
            $categories = Category::inRandomOrder()->take(rand(1, 4))->pluck('id');
            $factorybook->categories()->attach($categories);
        }
    }
}
