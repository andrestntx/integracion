<?php

	use Illuminate\Auth\UserInterface;
    use Illuminate\Auth\Reminders\RemindableInterface;

    class User extends Eloquent implements UserInterface, RemindableInterface{

    protected $fillable = array('name','username','email','password','create_at','updated_at', 'deleted_at');

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'tab_user';
    protected $softDelete = true;

    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = array('password');

    /**
    * Get the unique identifier for the user.
    *
    * @return mixed
    */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
    * Get the password for the user.
    *
    * @return string
    */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
    * Get the e-mail address where password reminders are sent.
    *
    * @return string
    */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function setPasswordAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function isValid($data)
    {
        $rules = array(
            'email' =>  'required|email|unique:tab_user',
            'username' =>  'required|min:4|max:32|unique:tab_user',
            'name' =>  'required|min:4|max:32',
            'password' =>  'min:4|confirmed'
        );

        if($this->exists){
            $rules['email'] .= ',email,' . $this->id;
            $rules['username'] .= ',username,' . $this->id;
        }

        else{
            $rules['password'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function validAndSave($data)
    {
        if ($this->isValid($data)) {
            $this->fill($data);
            $this->save();
            return true;
        }
        return false;
    }


}