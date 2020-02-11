<?php

use App\User;
use App\Position;
use App\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function ($user) {
            factory(Position::class, 1)->create([
                'admin_created_id' => $user->id,
                'admin_updated_id' => $user->id
            ])->each(function ($position) use ($user) {
                $headLevel = 0;
                for ($i = 0; $i < 5000; $i++)
                {
                    if($headLevel == 0)
                    {
                        factory(Employee::class, 1)->create([
                            'position_id' => $position->id,
                            'admin_created_id' => $user->id,
                            'admin_updated_id' => $user->id
                        ]);
                        $headLevel++;
                        continue;
                    }
                    elseif ($headLevel > 0 && $headLevel <= 4)
                    {
                        factory(Employee::class, 1)->create([
                            'head' => $i,
                            'position_id' => $position->id,
                            'admin_created_id' => $user->id,
                            'admin_updated_id' => $user->id
                        ]);
                        $headLevel++;
                        continue;
                    }
                    elseif ($headLevel == 5)
                    {
                        factory(Employee::class, 1)->create([
                            'head' => $i,
                            'position_id' => $position->id,
                            'admin_created_id' => $user->id,
                            'admin_updated_id' => $user->id
                        ]);
                        $headLevel = 0;
                        continue;
                    }
                }
            });
        });
    }
}
