<?php

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 10)
            ->create()->each(static function (\App\User $user) {
                factory(\App\Organisation::class)->create([
                    'owner_user_id' => $user->id,
                ]);
            });
    }
}
