<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests\Exceptions;


use JDWX\Strict\Exceptions\UnexpectedFailureException;
use PHPUnit\Framework\TestCase;


class UnexpectedFailureExceptionTest extends TestCase {


    public function testMessage() : void {
        $ex = new UnexpectedFailureException( 'foo' );
        self::assertSame( 'foo failed unexpectedly: (No error message provided)', $ex->getMessage() );

        $ex = new UnexpectedFailureException( 'foo', 'bar' );
        self::assertSame( 'foo failed unexpectedly: bar', $ex->getMessage() );
    }


}
