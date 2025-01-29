<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([

            TypesTableSeeder::class, // Seed types first
            UsersTableSeeder::class, // Seed users next
            ThemeSeeder::class,      // Seed themes
            ArticleSeeder::class,    // Seed articles
            HistorySeeder::class,    // Seed history

           
        ]);
    }
}
