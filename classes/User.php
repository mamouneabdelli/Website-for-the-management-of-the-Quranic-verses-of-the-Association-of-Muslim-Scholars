<?php

abstract class User {
    protected $id;
    protected $email;
    protected $first_name;
    protected $last_name;
    protected $password;
    protected $gender;
    protected $phone;
    protected $user_type;

    public function __construct($email, $password, $first_name = null, $last_name = null, $gender = null)
    {
        $this->email = $email;
        $this->password = $password;

        if ($first_name !== null) $this->first_name = $first_name;
        if ($last_name !== null) $this->last_name = $last_name;
        if ($gender !== null) $this->gender = $gender;
    }

    public abstract function login($user);
    public abstract function signup();
}