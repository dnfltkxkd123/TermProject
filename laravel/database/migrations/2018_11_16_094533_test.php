<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Test extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('doonate_book', function (Blueprint $table) {
            //$table->string('account',1000);
            
            $table->increments('num')->unsigned();
           $table->string('nickname',20);
            $table->string('title',50);
            $table->string('img',50);
            $table->string('thema',20);
            $table->string('content',1000);
            $table->string('date',50);
            
        });
        
        Schema::table('doonate_book',function(Blueprint $table){
            $table->string('account',1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('tests');
        Schema::table('doonate_book',function(Blueprint $table){
            $table->dropColumn('account');
        });
    }
}
