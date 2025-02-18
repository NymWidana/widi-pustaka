<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookCategories = [
            "Fiction",
            "Mystery",
            "Science Fiction",
            "Fantasy",
            "Romance",
            "Historical Fiction",
            "Thriller",
            "Horror",
            "Literary Fiction",
            "Non-Fiction",
            "Biography",
            "Autobiography",
            "Memoir",
            "Self-Help",
            "Health & Wellness",
            "History",
            "Travel",
            "True Crime",
            "Science & Nature",
            "Business & Economics",
            "Technology",
            "Children's Books",
            "Picture Books",
            "Early Readers",
            "Middle Grade",
            "Young Adult",
            "Academic",
            "Textbooks",
            "Reference Books",
            "Research Journals",
            "Essays & Theses",
            "Art & Photography",
            "Art History",
            "Photography Collections",
            "Graphic Design",
            "Lifestyle",
            "Cooking & Food",
            "Home & Garden",
            "Crafts & Hobbies",
            "Fashion & Beauty",
            "Religion & Spirituality",
            "Religious Texts",
            "Spiritual Growth",
            "Theology",
            "Poetry & Drama",
            "Poetry Collections",
            "Plays & Scripts",
            "Adventure",
            "Classics",
            "Comics & Graphic Novels",
            "Dystopian",
            "Short Stories",
            "Western",
            "Humor",
            "Parenting",
            "Politics",
            "Social Sciences",
            "Philosophy",
            "Reference",
            "Travel Guides",
            "Maps & Atlases",
            "Engineering",
            "Medical",
            "Law",
            "Architecture",
            "Environmental Studies",
            "Language Learning",
            "Music",
            "Sports & Recreation",
            "Anthologies"
        ];
        foreach($bookCategories as $bookCategory){
            Category::create(['name' => $bookCategory]);
        }
    }
}
