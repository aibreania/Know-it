<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    public function signup()
    {
        $check = $this->has_username_and_password();

        if(!$check)
            return ['status' => 0, 'msg' => 'Username and password cannot be empty'];

        $username = $check[0];
        $password = $check[1];

        $user_exists = $this
            ->where('username', $username)
            ->exists();
        if($user_exists)
            return ['status' => 0, 'msg' => 'Username already used'];

        $hashed_password = Hash::make($password);

        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;
        if($user->save())
            return ['status' => 1, 'id' => $user->id];
        else
            return ['status' => 0, 'msg' => 'DB insert failed'];
    }


    public function has_username_and_password() {
        $username = Request::get('username');
        $password = Request::get('password');

        if($username && $password)
            return [$username, $password];
        return false;
    }

    public function login() {
        $check = $this->has_username_and_password();
        if(!$check)
            return ['status' => 0, 'msg' => 'Username and password cannot be empty'];
        $username = $check[0];
        $password = $check[1];

        $user = $this->where('username', $username)->first();

        if(!$user)
            return ['status' => 0, 'msg' => 'User not exist'];

        $hashed_password = $user->password;
        if(!Hash::check($password, $hashed_password))
            return ['status' => 0, 'msg' => 'Wrong password'];

        session()->put('username', $user->username);
        session()->put('user_id', $user->id);


        return ['status' => 1, 'id' => $user->id];

    }

    public function is_logged_in() {
        return session('user_id') ? : false;
    }

    public function logout() {
        //session()->flush();
        //session()->put('username', null);
        //session()->put('user_id', null);
        //$username = session()->pull('username');
        //session()->set('person.name', 'Alex');
        //session()->set('person.friend.Hannah.age.sex.air', '20');
        session()->forget('username');
        session()->forget('user_id');
        //dd(session()->all());
        //return redirect('/');
        return ['status', 1];
    }
}
