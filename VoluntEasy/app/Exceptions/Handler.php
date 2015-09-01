<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e) {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {
        if ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        } elseif ($e instanceof ModelNotFoundException) {
            return $this->renderModelNotFoundException($e);
        } else if ($e instanceof TokenMismatchException) {
            return \Redirect::back()->withInput()->with('error', 'Your session was expired');
        } else {
            return parent::render($request, $e);
        }
    }


    protected function renderModelNotFoundException(ModelNotFoundException $e) {
        if (view()->exists('errors.404')) {
            return response()->view('errors.404', [], 404);
        }

    }
}
