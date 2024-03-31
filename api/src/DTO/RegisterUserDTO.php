<?php

namespace App\DTO;

use App\Constraint as AcmeAssert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

class RegisterUserDTO
{
    /**
     * @OA\Property(
     *     type="string",
     *     nullable=false,
     *     example="test@test.test"
     *)
     */
    #[SerializedName('email'),
        Assert\NotBlank(),
        Assert\NotNull(),
        Assert\Email(message: 'The email {{ value }} in not a valid email')]
    protected string $email;

    /**
     * @OA\Property(
     *     type="string",
     *     nullable=false,
     *     example="RegisterPass999"
     *)
     */
    #[SerializedName('password'),
        Assert\NotBlank(),
        Assert\NotNull(),
        AcmeAssert\PasswordWeak()]
    protected string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = strip_tags($email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = strip_tags($password);
    }
}
