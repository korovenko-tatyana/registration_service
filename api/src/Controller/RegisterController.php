<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\DTO\RegisterUserDTO;

class RegisterController extends AbstractController
{
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * @OA\Tag(name="Auth")
     * @OA\Post(summary="Register new user")
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *     ref=@Model(type=RegisterUserDTO::class)
     *    )
     * )
     * @OA\Response(
     *    response=200,
     *    description="Successful",
     *    @OA\JsonContent(
     *     @OA\Property(type="int", property="user_id", example=9),
     *     @OA\Property(type="string", property="password_check_status", ref="#/components/schemas/passwordStatus"),
     *     )
     *)
     * @OA\Response(
     *    response=400,
     *    description="Bad request",
     *    @OA\JsonContent(
     *     ref="#/components/schemas/400")
     * )
     */
    #[Route('/register', name: 'register_user', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        try {
            $userData = $this->userService->add($request);
        } catch (\Exception $e) {
            return new JsonResponse(['errorMessage' => $e->getMessage()], 400);
        }

        return new JsonResponse($userData);
    }
}
