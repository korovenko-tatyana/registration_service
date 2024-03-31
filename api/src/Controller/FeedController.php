<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

class FeedController extends AbstractController
{
    /**
     * @OA\Tag(name="Auth")
     * @Security(name="Bearer")
     * @OA\Get (summary="Check access_token")
     * @OA\Response(
     *    response=200,
     *    description="Successful"
     *)
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *     ref="#/components/schemas/401")
     *)
     */
    #[Route('/feed', name: 'feed_token', methods: 'GET')]
    public function index(): JsonResponse
    {
        return new JsonResponse();
    }
}
