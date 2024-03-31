<?php

namespace App\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PasswordWeak extends Constraint
{
    public $message = 'weak_password';
}
