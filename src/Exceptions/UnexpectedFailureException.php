<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Exceptions;


use Throwable;


class UnexpectedFailureException extends StrictException {


    public function __construct( string     $stWhatFailed, ?string $message = null, int $code = 0,
                                 ?Throwable $previous = null ) {
        $message ??= '(No error message provided)';
        parent::__construct( "{$stWhatFailed} failed unexpectedly: {$message}", $code, $previous );
    }


}
