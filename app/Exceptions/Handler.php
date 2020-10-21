<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\{
    JsonResponse,
    Request
};
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\{
    HttpException,
    MethodNotAllowedHttpException
};
use Throwable;

/**
 * Class Handler
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @var string
     */
    private string $message;

    /**
     * @var int
     */
    private int $status;

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @noinspection PhpMissingParamTypeInspection
     * @param Request   $request
     * @param Throwable $exception
     *
     * @return Response
     */
    public function render($request, Throwable $exception): Response
    {
        return $this->jsonResponse($request, $exception);
    }

    /**
     * @noinspection PhpUnusedParameterInspection
     * @param Request   $request
     * @param Throwable $e
     *
     * @return JsonResponse
     */
    public function jsonResponse(Request $request, Throwable $e): JsonResponse
    {
        $this->handleException($e);

        $response = [
            'message' => $this->message,
        ];

        if ($e instanceof ValidationException) {
            $response['validation'] = $e->errors();
        }

        return response()->json($response, $this->status);
    }

    /**
     * @param Throwable $e
     */
    private function handleException(Throwable $e): void
    {
        switch (get_class($e)) {
            case ModelNotFoundException::class:
                $this->message = ExceptionTypeEnum::NOT_FOUND;
                $this->status = Response::HTTP_NOT_FOUND;
                break;

            case ValidationException::class:
                $this->message = ExceptionTypeEnum::VALIDATION_FAILED;
                $this->status = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case AuthorizationException::class:
            case AuthenticationException::class:
            case HttpException::class:
                $this->message = ExceptionTypeEnum::ACCESS_DENIED;
                $this->status = Response::HTTP_FORBIDDEN;
                break;

            case MethodNotAllowedHttpException::class:
                $this->message = ExceptionTypeEnum::METHOD_NOT_ALLOWED;
                $this->status = Response::HTTP_METHOD_NOT_ALLOWED;
                break;

            default:
                $this->message = ($e->getMessage()) ?: ExceptionTypeEnum::INTERNAL_ERROR;
                $this->status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
    }
}
