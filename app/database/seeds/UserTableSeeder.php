<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		//DB::table('users')->delete();
		User::create(array(
			'id'	   => 5,
			'name'     => 'Nombre',
			'username' => 'usuario',
			'email'    => 'email',
			'password' => Hash::make('pass'),
		));
	}
}