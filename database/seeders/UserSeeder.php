<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;

class UserSeeder extends Seeder
{
  public function run(): void {
    User::create([
      'name' => '[Admin User]',
      'email' => 'admin@gmail.com',
      'avatar' => '/images/avatar.jpg',
      'password' => bcrypt('#Admin.123')
    ])
    ->addRole(Role::where('name', 'admin')->first(), Team::where('name', 'default')->first())
    ->addRole(Role::where('name', 'staff')->first(), Team::where('name', 'recruit')->first());

    User::create([
      'name' => '[Staff User]',
    'email' => 'staff@gmail.com',
      'avatar' => '/images/avatar.jpg',
      'password' => bcrypt('#Staff.123')
    ])->addRole(Role::where('name', 'staff')->first(), Team::where('name', 'default')->first())
    ->addRole(Role::where('name', 'admin')->first(), Team::where('name', 'recruit')->first());
  }
}
