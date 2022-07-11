<?php

namespace Database\Seeders;

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public array $customUsers;


    public function __construct()
    {
        $this->customUsers = [
            'admin@dibacapital.ir' => [
                User::FIRST_NAME => 'Admin',
                User::LAST_NAME => 'Dibal',
                User::INTERNATIONAL_NUMBER => '624986340',
                User::PASSWORD => bcrypt('Secret123'),
                User::MOBILE => '09122341292',
                User::SECURITY_QUESTION => User::QUESTION_FIRST_MOBILE,
                User::SECURITY_ANSWER => '09122341292',
                'roles' => [Role::ADMIN_ROLE, Role::USER_ROLE],
            ],
        ];
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->customUsers as $index => $customUser) {
            $roles = Role::whereIn(Role::TITLE, $customUser['roles'])->get();
            unset($customUser['roles']);
            $user = User::firstOrCreate([User::USERNAME => $index], $customUser);
            $user->roles()->sync($roles);
        }
    }
}
