<?php

namespace App\Traits;

use App\Constants\CommonResponseMessage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait CommonResponseTrait
{
    public function successResponse(
		string $message, 
		array $data = [], 
		int $statusCode = Response::HTTP_OK
		): JsonResponse
    {
        return response()
            ->json(['message' => $message] + $data, $statusCode);
    }

	public function validationErrorResponse(
		ValidationException $e,
		string $message = CommonResponseMessage::VALIDATION_ERROR,
		int $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY
	): JsonResponse
	{
		return response()->json(['message' => $message, 'errors' => $e->errors()], $statusCode);
	}
}
