<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        // Add themes related to your project
        $themes = [
            ['name' => 'Intelligence artificielle'],
            ['name' => 'Internet des objets'],
            ['name' => 'Cybersécurité'],
            ['name' => 'Réalité virtuelle et augmentée'],
            ['name' => 'Blockchain'],
            ['name' => 'Big Data'],
            ['name' => 'Cloud Computing'],
        ];
        foreach ($themes as $index => $themeData) {
            $userId = $index + 2; // User IDs start from 2
            Theme::create([
                'name' => $themeData['name'],
                'responsable_id' => $userId,
            ]);


        }
    }
}
?>
