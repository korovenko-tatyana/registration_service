<?php

namespace App\Service;

use App\DTO\RegisterUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ZxcvbnPhp\Zxcvbn;

class UserService
{
    public Zxcvbn $zxcvbn;

    public function __construct(
        protected EntityManagerInterface $em,
        protected SerializerInterface $serializer,
        protected UserRepository $userRepository,
        protected UserPasswordHasherInterface $passwordHasher,
        protected ValidatorInterface $validator,
    ) {
        $this->zxcvbn = new Zxcvbn();
    }

    public function save(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function add(Request $request): array
    {
        $userDTO = $this->validateDTO($request->getContent());

        $user = new User();
        $user->setEmail($userDTO->getEmail())
            ->setPassword($this->passwordHasher->hashPassword($user, $userDTO->getPassword()));

        $this->save($user);

        return $this->returnRegistrationData($user->getUserId(), $userDTO->getPassword());
    }

    private function returnRegistrationData(int $user_id, string $password): array
    {
        $weak = $this->zxcvbn->passwordStrength($password);

        return ['user_id' => $user_id, 'password_check_status' => (3 === $weak['score']) ? 'good' : 'perfect'];
    }

    private function validateDTO(string $content): object
    {
        $DTO = $this->serializer->deserialize($content, RegisterUserDTO::class, 'json');

        $this->checkErrors($DTO);

        return $DTO;
    }

    private function checkErrors(object $DTO): void
    {
        $errors = $this->validator->validate($DTO);

        if ($errors->count()) {
            $errorMessage = [];

            foreach ($errors as $error) {
                $errorMessage[] = sprintf('%s : %s', $error->getPropertyPath(), $error->getMessage());
            }

            throw new \Exception(json_encode($errorMessage));
        }
    }
}
