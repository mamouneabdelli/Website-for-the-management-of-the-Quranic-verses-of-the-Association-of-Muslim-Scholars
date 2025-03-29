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

    public abstract function login();
}