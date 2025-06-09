<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\TypeException;
use JDWX\Strict\TypeIs;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( TypeIs::class )]
final class TypeIsTest extends TestCase {


    public function testArray() : void {
        self::assertIsArray( TypeIs::array( [] ) );
        self::expectException( TypeException::class );
        TypeIs::array( 'not an array' );
    }


    public function testBool() : void {
        self::assertIsBool( TypeIs::bool( true ) );
        self::expectException( TypeException::class );
        TypeIs::bool( 'not a bool' );
    }


    public function testCallable() : void {
        self::assertIsCallable( TypeIs::callable( function () {
        } ) );
        self::expectException( TypeException::class );
        TypeIs::callable( 'not callable' );
    }


    public function testFloat() : void {
        self::assertIsFloat( TypeIs::float( 1.23 ) );
        self::assertIsFloat( TypeIs::float( 123 ) ); // int to float conversion
        self::expectException( TypeException::class );
        TypeIs::float( 'not a float' );
    }


    public function testInt() : void {
        self::assertIsInt( TypeIs::int( 123 ) );
        self::expectException( TypeException::class );
        TypeIs::int( 'not an int' );
    }


    public function testObject() : void {
        self::assertInstanceOf( $this::class, TypeIs::object( $this ) );
        self::expectException( TypeException::class );
        TypeIs::object( 'not an object' );
    }


    public function testString() : void {
        self::assertIsString( TypeIs::string( 'test' ) );
        self::expectException( TypeException::class );
        TypeIs::string( 123 ); // int is not a string
    }


    public function testStringy() : void {
        $stringable = new class implements \Stringable {


            public function __toString() : string {
                return 'stringable';
            }


        };
        self::assertSame( $stringable, TypeIs::stringy( $stringable ) );
        self::assertSame( 'foo', TypeIs::stringy( 'foo' ) );
        self::expectException( TypeException::class );
        TypeIs::stringy( 123 ); // int is not a string
    }


}