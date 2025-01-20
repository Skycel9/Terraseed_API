<?php

namespace App\Exceptions;

use App\Http\Resources\BaseResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
    protected $renderCustomExceptions = [
        AuthorizationException::class,
        ValidatorException::class,
        NotFoundException::class,
    ];
    protected $renderExceptions = [
        MethodNotAllowedHttpException::class
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception) {
        // Treat the exception with custom response
        if (in_array(get_class($exception), $this->renderCustomExceptions)) {
            $errorResponse = (new BaseResource([]))
                ->error()
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage())
                ->setErrors($exception->getErrors());

            return $errorResponse;
        }

        return parent::render($request, $exception);
    }
}
