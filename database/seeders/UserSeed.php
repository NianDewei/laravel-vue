<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rolando Dev',
            'email'=> 'admi.jmb@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456789')
        ]);

        User::create([
            'name' => 'Keane Dev',
            'email'=> 'keane-dev@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456789')
        ]);
    }
}
