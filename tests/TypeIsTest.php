<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Exceptions\TypeException;
use JDWX\Strict\TypeIs;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( TypeIs::class )]
final class TypeIsTest extends TestCase {


    public function testArray() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsArray( TypeIs::array( [] ) );
        self::expectException( TypeException::class );
        TypeIs::array( 'not an array' );
    }


    public function testArrayNullableString() : void {
        self::assertSame( [ 'foo', null ], TypeIs::arrayNullableString( [ 'foo', null ] ) );
        self::expectException( TypeException::class );
        TypeIs::arrayNullableString( [ 'foo', 123 ] );
    }


    public function testArrayNullableStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::arrayNullableString( 'not an array' );
    }


    public function testArrayString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayString( [ 'foo', 'bar' ] ) );
        self::expectException( TypeException::class );
        TypeIs::arrayString( [ 'foo', 123 ] );
    }


    public function testArrayStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::arrayString( 'not an array' );
    }


    public function testBool() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsBool( TypeIs::bool( true ) );
        self::expectException( TypeException::class );
        TypeIs::bool( 'not a bool' );
    }


    public function testCallable() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsCallable( TypeIs::callable( function () {} ) );
        self::expectException( TypeException::class );
        TypeIs::callable( 'not callable' );
    }


    public function testFloat() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsFloat( TypeIs::float( 1.23 ) );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsFloat( TypeIs::float( 123 ) ); # implicit int-to-float conversion even for strict types
        self::expectException( TypeException::class );
        TypeIs::float( 'not a float' );
    }


    public function testInt() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsInt( TypeIs::int( 123 ) );
        self::expectException( TypeException::class );
        TypeIs::int( 'not an int' );
    }


    public function testListNullableString() : void {
        self::assertSame( [ 'foo', null ], TypeIs::listNullableString( [ 'foo', null ] ) );
        self::expectException( TypeException::class );
        self::expectExceptionMessage( '?string value' );
        self::assertSame( [ 'foo', null ], TypeIs::listNullableString( [ 'foo', 123 ] ) );
    }


    public function testListNullableStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::listNullableString( 'not an array' );
    }


    public function testListNullableStringForStringKey() : void {
        self::expectException( TypeException::class );
        self::expectExceptionMessage( 'int key' );
        TypeIs::listNullableString( [ 'foo', 'bar' => null ] );
    }


    public function testListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listString( [ 'foo', 'bar' ] ) );
        self::expectException( TypeException::class );
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listString( [ 'foo', 'baz' => 'bar' ] ) );
    }


    public function testListStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::listString( 'not an array' );
    }


    public function testListStringForValueNotString() : void {
        self::expectException( TypeException::class );
        TypeIs::listString( [ 'foo', 123 ] );
    }


    public function testObject() : void {
        self::assertInstanceOf( $this::class, TypeIs::object( $this ) );
        self::expectException( TypeException::class );
        TypeIs::object( 'not an object' );
    }


    public function testResource() : void {
        self::assertIsResource( TypeIs::resource( fopen( __FILE__, 'r' ) ) );
        self::expectException( TypeException::class );
        TypeIs::resource( 'not a resource' );
    }


    public function testString() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( TypeIs::string( 'test' ) );
        self::expectException( TypeException::class );
        TypeIs::string( 123 );
    }


    public function testStringOrListString() : void {
        self::assertSame( 'foo', TypeIs::stringOrListString( 'foo' ) );
        self::assertSame( [ 'foo', 'bar' ], TypeIs::stringOrListString( [ 'foo', 'bar' ] ) );
        self::expectException( TypeException::class );
        TypeIs::stringOrListString( 123 );
    }


    public function testStringOrNull() : void {
        self::assertSame( 'foo', TypeIs::stringOrNull( 'foo' ) );
        self::assertNull( TypeIs::stringOrNull( null ) );
        self::expectException( TypeException::class );
        TypeIs::stringOrNull( 123 );
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
        TypeIs::stringy( 123 );
    }


    public function testStringyOrNull() : void {
        $stringable = new class implements \Stringable {


            public function __toString() : string {
                return 'stringable';
            }


        };
        self::assertSame( 'foo', TypeIs::stringyOrNull( 'foo' ) );
        self::assertSame( $stringable, TypeIs::stringyOrNull( $stringable ) );
        self::assertNull( TypeIs::stringyOrNull( null ) );
        self::expectException( TypeException::class );
        TypeIs::stringyOrNull( false );
    }


    public function testTrue() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( TypeIs::true( true ) );
        self::expectException( TypeException::class );
        TypeIs::true( 'not a bool' );
    }


}