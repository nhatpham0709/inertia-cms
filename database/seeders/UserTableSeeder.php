<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->username = 'nhatpham0709';
        $admin->name = 'Nhat Pham';
        $admin->email = 'nhatpham0709@gmail.com';
        $admin->status = USER_STATUS_ACTIVE;
        $admin->password = bcrypt('12345678');
        $admin->save();
        $admin->roles()->attach(Role::where('name', USER_ROLE_ADMIN)->first());

        User::factory(100)->create();
    }
}
