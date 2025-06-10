<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests\Exceptions;


use JDWX\Strict\Exceptions\TypeException;
use PHPUnit\Framework\TestCase;
use stdClass;


class TypeExceptionTest extends TestCase {


    public function testMessage() : void {
        $ex = new TypeException( 'foo', 'bar', 'baz' );
        self::assertSame( 'For baz: expected foo got string ("bar")', $ex->getMessage() );

        $ex = new TypeException( 'foo', 'FooBarBazQux', 'baz' );
        self::assertSame( 'For baz: expected foo got string ("FooBarB...")', $ex->getMessage() );

        $ex = new TypeException( 'foo', 123 );
        self::assertSame( 'For type check: expected foo got integer (123)', $ex->getMessage() );

        $ex = new TypeException( 'foo', [ 1, 2 ], 'bar' );
        self::assertSame( 'For bar: expected foo got array (array[2])', $ex->getMessage() );

        $ex = new TypeException( 'foo', new stdClass(), 'bar' );
        self::assertSame( 'For bar: expected foo got stdClass (object)', $ex->getMessage() );

        $ex = new TypeException( 'foo', null, 'bar' );
        self::assertSame( 'For bar: expected foo got NULL (null)', $ex->getMessage() );

        $ex = new TypeException( 'foo', true, 'bar' );
        self::assertSame( 'For bar: expected foo got boolean (true)', $ex->getMessage() );

        $ex = new TypeException( 'foo', false, 'bar' );
        self::assertSame( 'For bar: expected foo got boolean (false)', $ex->getMessage() );

        $fh = fopen( 'php://memory', 'r' );
        $ex = new TypeException( 'foo', $fh, 'bar' );
        self::assertSame( 'For bar: expected foo got resource (stream)', $ex->getMessage() );
        fclose( $fh );
    }


}
