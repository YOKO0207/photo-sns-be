<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Symfony\Component\HttpKernel\Exception\{ 
	NotFoundHttpException, 
	MethodNotAllowedHttpException 
};
use Illuminate\Database\Eloquent\{
	ModelNotFoundException,
	MassAssignmentException,
};
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use App\Constants\CommonResponseMessage;
use App\Traits\CommonResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
	use CommonResponseTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

		$this->renderable(function (Throwable $e, $request) {

			if ($e instanceof TokenMismatchException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::BAD_REQUEST;
				return response()->json(['message' => $message], Response::HTTP_BAD_REQUEST); //400
			}

			if ($e instanceof AuthenticationException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::UNAUTHORIZED;
				return response()->json(['message' => $message], Response::HTTP_UNAUTHORIZED); //401
			}
			
			if ($e instanceof AuthorizationException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::FORBIDDEN;
				return response()->json(['message' => $message], Response::HTTP_FORBIDDEN); //403
			}

			if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::NOT_FOUND;
				return response()->json(['message' => $message], Response::HTTP_NOT_FOUND); //404
			}

			if ($e instanceof FileNotFoundException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::NOT_FOUND;
				return response()->json(['message' => $message], Response::HTTP_NOT_FOUND); //404
			}

			if ($e instanceof MethodNotAllowedHttpException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::METHOD_NOT_ALLOWED;
				return response()->json(['message' => $message], Response::HTTP_METHOD_NOT_ALLOWED); //405
			}

			if ($e instanceof ValidationException) {
				return $this->validationErrorResponse($e); // 422
			}

			if ($e instanceof TooManyRequestsHttpException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::TOO_MANY_REQUESTS;
				return response()->json(['message' => $message], Response::HTTP_TOO_MANY_REQUESTS); //429
			}

			if ($e instanceof QueryException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::INTERNAL_SERVER_ERROR;
				return response()->json(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR); //500
			}

			if($e instanceof MassAssignmentException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::INTERNAL_SERVER_ERROR;
				return response()->json(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR); //500
			}

			if ($e instanceof RelationNotFoundException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::BAD_RELATIONSHIP;
				return response()->json(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR); //500
			}

			if ($e instanceof InvalidSignatureException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::INVALIDE_SIGNATURE;
				return response()->json(['message' => $message], Response::HTTP_INTERNAL_SERVER_ERROR); //500
			}

			if ($e instanceof HttpException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::BAD_REQUEST;
				return response()->json(['message' => $message], $e->getStatusCode());
			}

			// Custom Exception
			if ($e instanceof DeleteFailedException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::DELETE_FAILED;
				return response()->json(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY); //422
			}

			if ($e instanceof UpdateFailedException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::UPDATE_FAILED;
				return response()->json(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY); //422
			}

			if ($e instanceof FileUploadFailedException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::FILE_UPLOAD_FAILED;
				return response()->json(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY); //422
			}

			if ($e instanceof FileDeleteFailedException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::FILE_DELETE_FAILED;
				return response()->json(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY); //422
			}

			if ($e instanceof UserNotExistException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::USER_NOT_EXIST;
				return response()->json(['message' => $message], Response::HTTP_NOT_FOUND); //404
			}

			if ($e instanceof TokenInvalidException) {
				$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::INVALID_TOKEN;
				return response()->json(['message' => $message], Response::HTTP_UNAUTHORIZED); //401
			}

			// This will handle all other exceptions which are not handled above
			$message = config('app.env') === 'local' ? $e->getMessage() : CommonResponseMessage::INTERNAL_SERVER_ERROR;
			return response()->json(['message' => $message], 500);
		});
    }
}

