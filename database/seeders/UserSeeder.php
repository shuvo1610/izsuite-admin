<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $recruiterRoleId = Role::where('slug', 'recruiter')->value('id');
        $candidateRoleId = Role::where('slug', 'candidate')->value('id');

        User::firstOrCreate(
            ['email' => 'admin@resumist.io'],
            [
                'name'     => 'Admin',
                'password' => '123456',
                'role_id'  => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'recruiter@resumist.io'],
            [
                'name'     => 'Recruiter Demo',
                'password' => '123456',
                'role_id'  => $recruiterRoleId,
            ]
        );

        User::firstOrCreate(
            ['email' => 'candidate@resumist.io'],
            [
                'name'     => 'Candidate Demo',
                'password' => '123456',
                'role_id'  => $candidateRoleId,
            ]
        );
    }
}
