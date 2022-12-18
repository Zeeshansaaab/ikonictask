<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(1)->connections()->sync([3, 4, 5]);
        User::find(2)->connections()->sync([3, 4, 5]);

    }
}
