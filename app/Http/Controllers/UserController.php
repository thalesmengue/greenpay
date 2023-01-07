<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $user
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->user->all()
        ], Response::HTTP_OK);
    }

    public function show($id): JsonResponse
    {
        return response()->json([
            'data' => $this->user->find($id)
        ], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->user->create($request->all())
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id): JsonResponse
    {
        return response()->json([
            'data' => $this->user->update($request->all(), $id)
        ], Response::HTTP_OK);
    }

    public function destroy($id): JsonResponse
    {
        return response()->json([
            'data' => $this->user->destroy($id)
        ], Response::HTTP_NO_CONTENT);
    }
}
