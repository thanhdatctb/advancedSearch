<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(\Illuminate\Http\Request $request)
    {
        $mainController = new \App\Http\Controllers\MainController();
        $mainController->backup($request);
        // $this->call(UsersTableSeeder::class);
    }
}
