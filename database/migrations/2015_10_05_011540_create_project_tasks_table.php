<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            
            $table->text('name');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->smallInteger('status')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_tasks');
    }
}
