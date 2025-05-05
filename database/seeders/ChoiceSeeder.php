<?php

namespace Database\Seeders;

use App\Models\Choice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('data/story_data.json')), true);

        foreach ($data['choices'] as $choiceData) {
            Choice::create($choiceData);
        }
    }
}
