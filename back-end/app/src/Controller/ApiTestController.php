<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiTestController
{
    #[Route('/api/test', name: 'api_test')]
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Hello World',
            'success' => true
        ]);
    }
}
