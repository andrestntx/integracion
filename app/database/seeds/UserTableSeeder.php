<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		//DB::table('users')->delete();
		User::create(array(
			'id'	   => 1,
			'name'     => 'Ing. Linda Guzman',
			'username' => 'lindaguzman',
			'email'    => 'linda.guzman@sypelcltda',
			'password' => Hash::make('lguzman'),
		));
	}
}