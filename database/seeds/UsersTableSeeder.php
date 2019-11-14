<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('acl.roles') as $roleName) {
            $total = $roleName == 'customer' ? 5 : 1;

            foreach (range(1, $total) as $index) {
                $username = $index == 1 ? $roleName : $roleName . $index;
                $user = factory(\App\Models\User::class)->create([
                    'email' => "{$username}@example.com",
                ]);

                $user->assignRole($roleName);
            }

        }
    }
}
