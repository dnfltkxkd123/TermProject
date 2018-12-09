<?php

use Illuminate\Database\Seeder;
use App\Test;
class Tests_Table_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	Test::create([

     		'user_id' => '찬민',
     		'age' => 24,
     		'email' => 'pyc2238'
     	]);   
    }
}
