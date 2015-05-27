<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('username', 64);
			$table->string('email', 256);
			$table->string('fimfic', 256)->nullable();
			$table->string('password', 64);
			$table->boolean('want_feedback')->nullable();
			$table->boolean('contestant');
			$table->boolean('reviewer');
			$table->string('review_phase', 64)->default("Public");
			$table->boolean('judge');
			$table->boolean('admin');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
		});

		Schema::create('stories', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('title', 256);
			$table->string('url', 256)->nullable();
			$table->text('body');
			$table->string('phase', 64);
			$table->timestamps();
		});

		Schema::create('reviews', function($table)
		{
			$table->increments('id');
			$table->boolean('pending');
			$table->integer('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('story_id');
			$table->foreign('story_id')->references('id')->on('stories');
			$table->string('phase', 64);
			$table->tinyInteger('technical_score')->nullable();
			$table->tinyInteger('structure_score')->nullable();
			$table->tinyInteger('theme_score')->nullable();
			$table->tinyInteger('impact_score')->nullable();
			$table->tinyInteger('misc_score')->nullable();
			$table->text('notes')->nullable();
			$table->timestamps();
		});


	Schema::create('contests', function($table)
		{
			$table->increments('id');
			$table->text('general_rules')->nullable();
			$table->text('secret_rules')->nullable();
			$table->timestamp('start_time')->nullable();
			$table->timestamp('stop_time')->nullable();
			$table->integer('grace_time')->nullable();
			$table->integer('required_reviews');
			$table->boolean('locked')->nullable();
			$table->boolean('publiclist')->nullable();
			$table->boolean('publicreviews')->nullable();
			$table->string('current_phase', 64);
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
		Schema::drop('users');
		Schema::drop('stories');
		Schema::drop('reviews');
		Schema::drop('contests');
	}

}
