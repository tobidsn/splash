<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$faker = Faker\Factory::create();

    	for ($i=0; $i < 10; $i++) { 		
	    	DB::table('tweets')->insert([
	    		'body' => $faker->realText(140),
	    		'user_id' => 1,
                'created_at' => Carbon\Carbon::now(),
	    	]);
    	}
    }
}
