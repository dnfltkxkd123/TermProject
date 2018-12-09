<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;

class OrmController extends Controller
{
    //
    public function getAll(){
    	/*
    	$task = Test::where('id','<',3)
    	->first();

    	return view('t')->with('test',$task);
    	*/
    	/*
    	$test = Test::dueInDays(7)
    	->take(2)
    	->get();
    	*/

    	$test = Test::create([
    		'user_id'=>'Test',
    		'account'=>'1232345',
    		'email'=>'test@test',
    		'age'=>56,
    	]);

    	dump($test);

    	$u2 = Test::find($test->id);
    	dump($u2->account);
    	dump($u2->account);
    	//return view('t') -> with('test',$test);
    }
}
