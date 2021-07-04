<?php

namespace App\Dto;

class UserDto extends DataTransferObject
{
    public string $login;
    public string $password;
    public string $phone;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $telegram_id;

    public string $role;
}