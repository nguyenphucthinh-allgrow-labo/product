<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler {
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }


	/**
	 * Convert the given exception to an array.
	 *
	 * @param Throwable  $e
	 * @return array
	 */
	protected function convertExceptionToArray(Throwable $e) {
		return config('app.debug') ? [
			'msg' => $e instanceof ValidationException ? __('common/error.invalid-request-data') : __('common/error.system-error'),
			'errorMessage' => $e->getMessage(),
			'exception' => get_class($e),
			'file' => $e->getFile(),
			'line' => $e->getLine(),
			'trace' => collect($e->getTrace())->map(function ($trace) {
				return Arr::except($trace, ['args']);
			})->all(),
		] : [
			'msg' => !($e instanceof ValidationException)
				? __('common/error.system-error')
				: __('common/error.invalid-request-data'),
		];
	}
}
