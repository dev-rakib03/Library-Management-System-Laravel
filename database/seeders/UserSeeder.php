<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::where('email', 'superadmin@mail.com')->first();
        if (is_null($user)) {
            $user = new Admin();
            $user->name = "Super Admin";
            $user->username = "superadmin";
            $user->email = "superadmin@mail.com";
            $user->password = Hash::make('12345678');
            $user->save();
        }

    }
}
