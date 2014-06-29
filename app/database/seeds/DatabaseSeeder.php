<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();


	        User::create(array('username' => 'test-user', 'email' => 'foo@bar.com', 'password' => Hash::make('test')));

		// $this->call('UserTableSeeder');
	}

}
