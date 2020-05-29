<?php

use App\Entities\Container;
use Illuminate\Database\Seeder;

class ContainerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Container::class, 10)->create();
    }
}
