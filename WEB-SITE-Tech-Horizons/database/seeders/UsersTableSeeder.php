<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Type;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch the types
        $abonneType = Type::where('name', 'Abonné')->first();
        $editeurType = Type::where('name', 'Editeur')->first();
        $responsableType = Type::where('name', 'Responsable')->first();

         // Create Editeur users
         User::create([
            'name' => 'Wail Editeur',
            'email' => 'wail1@test.com',
            'password' => Hash::make('editeur123'),
            'type_id' => $editeurType->id,
        ]);

     
        // Create a Responsable user for each theme
        for ($i = 1; $i <= 7; $i++) {
            User::create([
                'name' => 'Responsable ' . $i, // e.g., "Responsable 1"
                'email' => 'responsable' . $i . '@test.com', // e.g., "responsable1@test.com"
                'password' => Hash::make('responsable123'), // Same password for all
                'type_id' => $responsableType->id, // Use the fetched Responsable type ID
            ]);
        } 
    }
}