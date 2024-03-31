<?php

namespace App\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ZxcvbnPhp\Zxcvbn;

class PasswordWeakValidator extends ConstraintValidator
{
    public Zxcvbn $zxcvbn;

    public function __construct()
    {
        $this->zxcvbn = new Zxcvbn();
    }

    public function validate($value, Constraint $constraint)
    {
        $weak = $this->zxcvbn->passwordStrength($value ?? '');

        if ($weak['score'] < 3)
            $this->context->buildViolation($constraint->message)
                ->addViolation();
    }
}
