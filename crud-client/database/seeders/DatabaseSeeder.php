<?php

namespace Database\Seeders;

use App\Helpers\CryptoHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

           User::create([
            'user' => CryptoHelper::encrypt('admin@gmail.com'),
            'name' => CryptoHelper::encrypt('Usuario API'),
            'phone' => CryptoHelper::encrypt('3312345678'),
            'password' => Hash::make('Pass123!'),
            'consent_id1' => Str::random(30),
            'consent_id2' => null,
            'consent_id3' => null,
        ]);
    }
}
