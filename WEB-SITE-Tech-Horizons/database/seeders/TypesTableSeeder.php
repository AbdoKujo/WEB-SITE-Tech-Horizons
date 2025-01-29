<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Type;
use App\Models\Theme;

class TypesTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch all themes
    
            // Define the types to be created
            $types = [
                ['name' => 'Editeur'],
                ['name' => 'Responsable'],
                ['name' => 'Abonné'],
            ];
    
            // Create the types
            foreach ($types as $type) {
                Type::create($type);
            }
    }


    
}