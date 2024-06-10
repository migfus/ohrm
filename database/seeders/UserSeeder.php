<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use App\Models\GroupMember;
use App\Models\Group;
use App\Models\GroupRole;

class UserSeeder extends Seeder
{
  public function run(): void {
    // NOTE: SYSTEM ROLE
    $roles = [
      'admin' => Role::where('name', 'admin')->first(),
      'staff' => Role::where('name', 'staff')->first(),
      'head' => Role::where('name', 'head')->first(),
    ];

    // NOTE: GROUP CONFIG
    $groups = [
      'ohrm' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'rsp' => Group::where('name', 'Recruitment, Selection and Placement')->first()->id,
      'lad' => Group::where('name', 'Learning and Development')->first()->id,
      'coberu' => Group::where('name', 'Compensation, Benefits and Employee Relations Unit')->first()->id,
      'hris' => Group::where('name', 'Human Resource Information System Unit Process')->first()->id,
      'perma' => Group::where('name', 'Performance Management')->first()->id,
    ];
    $group_roles = [
      'admin' => GroupRole::where('name', 'admin')->first()->id,
      'member' => GroupRole::where('name', 'member')->first()->id
    ];

    // NOTE: Units
    $this->OHRMUsers($groups['ohrm'], $roles, $group_roles);

    $this->RSPUsers($groups['rsp'], $roles, $group_roles);
    $this->PERMAUsers($groups['perma'], $roles, $group_roles);
    $this->LADUsers($groups['lad'], $roles, $group_roles);
    $this->HRISUsers($groups['hris'], $roles, $group_roles);
    $this->COBERUUsers($groups['coberu'], $roles, $group_roles);
  }


  private function OHRMUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => '[Admin User]',
      'email' => 'admin@gmail.com',
      'avatar' => 'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
      'cover' => 'https://images.pexels.com/photos/268941/pexels-photo-268941.jpeg',
      'password' => bcrypt('#Admin.123')
    ])
      ->addRole($roles['admin']);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);

    $user = User::create([
      'name' => '[Staff User]',
      'email' => 'staff@gmail.com',
      'avatar' => 'https://plus.unsplash.com/premium_photo-1687609111091-4e37d8f1ae41?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
      'cover' => 'https://media.istockphoto.com/id/1208738316/photo/abstract-geometric-network-polygon-globe-graphic-background.webp?b=1&s=170667a&w=0&k=20&c=Ewa2JDeA8E9k9ch3IYWkSYdEkTEhyaMNfNLkClag-j4=',
      'password' => bcrypt('#Staff.123')
    ])
      ->addRole($roles['staff']);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);

    // NOTE: OHRM
    $user = User::create([
      'name' => 'Athena Jan I. Derayunan',
      'email' => 'f.athenajanderayunan@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf116db47a55f815653ed1757103f59baeb035ea.jpg',
      'cover' => 'https://t4.ftcdn.net/jpg/05/31/79/83/360_F_531798391_XFz7gyPmDRTAfiEE5sRjFu5NpKrJt4rC.jpg',
      'password' => bcrypt('12345678')
    ])
      ->addRole($roles['head']);
      $this->AssignGroup($user->id, $group_id, $group_roles['admin']);
  }

  private function RSPUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => 'Marcelino F. Duay III.',
      'email' => 's.duaymarcelino@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf05c67567f40d3493d1134e4c400d00381056ba.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);

    $user = User::create([
      'name' => 'Eunice Jane O. Sarausa',
      'email' => 's.eunicejanesarausa@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf05d95934570f7efd1daca927d3355e72c7271e.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);


    User::create([
      'name' => 'Charlotte G. Sanchez',
      'email' => 's.charlottesanchez@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf074a7e1776a77c24c1286631dc9013359c4a09.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);
  }

  private function LADUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => 'Nolan Earl E. Guzman',
      'email' => 's.nolan@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf0349e812e2be0892dcb763e5c559cf7ed9dbea.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);

    $user = User::create([
      'name' => 'Vashti Jael I. Naduma',
      'email' => 's.vashti@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf03661c9c4af861017c502d5b168336b038eb7e.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);

    $user = User::create([
      'name' => 'Rhizza Mae T. Sungahid',
      'email' => 's.rhizza@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf040f7a4a4daa967dcaa266a5fc70c7acf38f65.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);
  }

  private function PERMAUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => 'Jernafernagen J. Delada',
      'email' => 's.jerna@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf05c3cfe01518f955962968e2aacc5fc7db6de2.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);
  }

  private function HRISUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => 'Schwarzenegger R. Belonio',
      'email' => 'schwarzenegger.belonio@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf02cc9f80d35748c69264002450ca07308a7c59.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);

    $user = User::create([
      'name' => 'Ruel G. Tutas III.',
      'email' => 's.ruel@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf025bb301673194b22ea58c007de403edbd19e0.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);
  }

  private function COBERUUsers($group_id, $roles, $group_roles): void {
    $user = User::create([
      'name' => 'Paul Calvin B. Rubio',
      'email' => 's.paulcalvin@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf0142020f4ba0c72722cfcd3988f0106a90dac8.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['admin']);

    $user = User::create([
      'name' => 'Lucena R. Catane',
      'email' => 's.catane@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf02159758091682c25f6c09c6d0fe68206723ed.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);

    $user = User::create([
      'name' => 'Divina S. Toquib',
      'email' => 's.divina@cmu.edu.ph',
      'avatar' => 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/cf/cf025513ba6a5edeeefff9f69ad1eadce006fa4f.jpg',
      'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s',
      'password' => bcrypt('12345678')
    ])->addRole($roles['staff']);
    $this->AssignToOHRMAsMember($user->id);
    $this->AssignGroup($user->id, $group_id, $group_roles['member']);
  }


  private function AssignGroup($user_id, $group_id, $group_role_id) : void {
    GroupMember::create([
      'user_id' => $user_id,
      'group_id' => $group_id,
      'group_role_id' => $group_role_id
    ]);
  }
  private function AssignToOHRMAsMember($user_id) : void {
    GroupMember::create([
      'user_id' => $user_id,
      'group_id' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'group_role_id' => GroupRole::where('name', 'member')->first()->id,
    ]);
  }
}
