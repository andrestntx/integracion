<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		//DB::table('users')->delete();
		User::create(array(
			'name'     => 'Ing. Linda Guzman',
			'username' => 'lindaguzman',
			'email'    => 'linda.guzman@sypelcltda.com',
			'password' => Hash::make('lguzman'),
		));
	}
}