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


    $contest = new Contest;
    $contest->locked = 0;
    $contest->grace_time = 5;
    $contest->general_rules = "[b]General Rules[/b]
General rules go [i]here.[/i]";
    $contest->secret_rules = "[b]Secret Rules[/b]
Secret rules go [i]here.[/i]";
    $contest->start_time = time();
    $contest->stop_time = strtotime('2015/10/17');
    $contest->max_reviews = 3;

    $contest->save();


    User::create(array('username' => 'Xepher', 'email' => 'xepher@xepher.net', 'password' => Hash::make('test'), 'admin' => 1, 'judge' => 1, 'reviewer' => 1, 'contestant' => 0 ));

  }

}
