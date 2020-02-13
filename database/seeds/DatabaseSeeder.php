<?php

use App\User;
use App\Position;
use App\Employee;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Position::unsetEventDispatcher();

        $faker = Factory::create();

        // Добавил 10 юзеров (админов) с ид от 1 до 10.
        factory(User::class, 10)->create();

        // Добавляю 20 должностей с ид от 1 до 20, ид админа создавшего/обновившего выбираю от 1 до 10.
        for ($i = 0; $i < 20; $i++) {
            factory(Position::class, 1)->create([
                'admin_created_id' => $faker->numberBetween(1, 10),
                'admin_updated_id' => $faker->numberBetween(1, 10),
                'created_at' => $faker->dateTime('now', 'Europe/Moscow'),
            ]);
        }

        // Добавляю 50к работников, ид админа создавшего/обновившего выбираю от 1 до 10.
        // Должность выбираю рандомно от 1 до 20.
        // Уровень подчинения от 0 до 5. 0 - без руководителя. 1-5 - руководитель с ид $i.
        $headLevel = 0;
        for ($i = 0; $i < 50000; $i++) {
            factory(Employee::class, 1)->create([
                'head' => ($headLevel !== 0) ? $i : null,
                'position_id' => $faker->numberBetween(1, 20),
                'admin_created_id' => $faker->numberBetween(1, 10),
                'admin_updated_id' => $faker->numberBetween(1, 10),
            ]);
            $headLevel = ($headLevel == 5) ? 0 : ++$headLevel;
        }

        Position::setEventDispatcher(new \Illuminate\Events\Dispatcher);
    }
}
