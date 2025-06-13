<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Exceptions\TypeException;
use JDWX\Strict\TypeIs;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stringable;


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


    public function testArrayNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::arrayNullableStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        self::expectException( TypeException::class );
        TypeIs::arrayNullableStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testArrayNullableStringyForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::arrayNullableStringy( 'not an array' );
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


    public function testArrayStringOrListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayStringOrListString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], TypeIs::arrayStringOrListString( [ 'foo', [ 'bar', 'baz' ] ] ) );
        self::expectException( TypeException::class );
        TypeIs::arrayStringOrListString( 123 );
    }


    public function testArrayStringOrListStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::arrayStringOrListString( 'not an array' );
    }


    public function testArrayStringy() : void {
        $stringable = self::stringable();
        self::assertSame( [ 'foo', $stringable ], TypeIs::arrayStringy( [ 'foo', $stringable ] ) );
        self::expectException( TypeException::class );
        TypeIs::arrayStringy( [ 'foo', 123 ] );
    }


    public function testArrayStringyForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::arrayStringy( 'not an array' );
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


    public function testIterable() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterable( $it ) ) );
        self::expectException( TypeException::class );
        TypeIs::iterable( 'not iterable' );
    }


    public function testIterableNullableString() : void {
        $it = $this->generator( [ 'foo', null ] );
        self::assertSame( [ 'foo', null ], iterator_to_array( TypeIs::iterableNullableString( $it ) ) );
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableString( [ 'foo', 123 ] ) );
    }


    public function testIterableNullableStringForNotIterable() : void {
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableString( 123 ) );
    }


    public function testIterableNullableStringy() : void {
        $stringable = self::stringable();
        $it = $this->generator( [ 'foo', $stringable ] );
        self::assertSame( [ 'foo', $stringable ], iterator_to_array( TypeIs::iterableNullableStringy( $it ) ) );
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableStringy( [ 'foo', 123 ] ) );
    }


    public function testIterableNullableStringyForNotIterable() : void {
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableStringy( 123 ) );
    }


    public function testIterableString() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterableString( $it ) ) );
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableString( [ 'baz', 123 ] ) );
    }


    public function testIterableStringForNotIterable() : void {
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableString( 123 ) );
    }


    public function testIterableStringOrListString() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterableStringOrListString( $it ) ) );
        $it = $this->generator( [ 'foo', [ 'bar', 'baz' ] ] );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], iterator_to_array( TypeIs::iterableStringOrListString( $it ) ) );
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrListString( 123 ) );
    }


    public function testIterableStringOrListStringForNotIterable() : void {
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrListString( 'not iterable' ) );
    }


    public function testIterableStringy() : void {
        $stringable = self::stringable();
        $it = $this->generator( [ 'foo', $stringable ] );
        self::assertSame( [ 'foo', $stringable ], iterator_to_array( TypeIs::iterableStringy( $it ) ) );
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringy( [ 'foo', 123 ] ) );
    }


    public function testIterableStringyForNotIterable() : void {
        self::expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringy( 123 ) );
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


    public function testListNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo', $stringable ],
            iterator_to_array( TypeIs::listNullableStringy( [ 'foo', $stringable ] ) )
        );
        self::expectException( TypeException::class );
        self::assertSame( [ 'foo', $stringable ], TypeIs::listNullableStringy( [ 'foo', 123 ] ) );
    }


    public function testListNullableStringyForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::listNullableStringy( 'not an array' );
    }


    public function testListNullableStringyForStringKey() : void {
        self::expectException( TypeException::class );
        self::expectExceptionMessage( 'int key' );
        TypeIs::listNullableStringy( [ 'foo', 'bar' => null ] );
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


    public function testListStringOrListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listStringOrListString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], TypeIs::listStringOrListString( [ 'foo', [ 'bar', 'baz' ] ] ) );
        self::expectException( TypeException::class );
        TypeIs::listStringOrListString( [ 123 ] );
    }


    public function testListStringOrListStringForKeyNotInt() : void {
        self::expectException( TypeException::class );
        TypeIs::listStringOrListString( [ 'foo' => 'bar' ] );
    }


    public function testListStringOrListStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::listStringOrListString( 'not an array' );
    }


    public function testListStringy() : void {
        $stringable = self::stringable();
        self::assertSame( [ 'foo', $stringable ], TypeIs::listStringy( [ 'foo', $stringable ] ) );
        self::expectException( TypeException::class );
        self::assertSame( [ 'foo', $stringable ], TypeIs::listStringy( [ 'foo', 123 ] ) );
    }


    public function testListStringyForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::listStringy( 'not an array' );
    }


    public function testListStringyForStringKey() : void {
        $stringable = self::stringable();
        self::expectException( TypeException::class );
        self::expectExceptionMessage( 'int key' );
        TypeIs::listStringy( [ 'foo', 'bar' => $stringable ] );
    }


    public function testMapNullableString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => null ], TypeIs::mapNullableString( [ 'foo' => 'bar', 'baz' => null ] ) );
        self::expectException( TypeException::class );
        TypeIs::mapNullableString( [ 'foo' => 123, 'baz' => null ] );
    }


    public function testMapNullableStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::mapNullableString( 'not an array' );
    }


    public function testMapNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::mapNullableStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        self::expectException( TypeException::class );
        TypeIs::mapNullableStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testMapString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => 'qux' ], TypeIs::mapString( [ 'foo' => 'bar', 'baz' => 'qux' ] ) );
        self::expectException( TypeException::class );
        TypeIs::mapString( [ 'foo' => 123, 'baz' => 'qux' ] );
    }


    public function testMapStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::mapString( 'not an array' );
    }


    public function testMapStringOrListString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ], TypeIs::mapStringOrListString( [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ] ) );
        self::expectException( TypeException::class );
        TypeIs::mapStringOrListString( [ 'foo' => 123, 'baz' => [ 'qux', 'quux' ] ] );
    }


    public function testMapStringOrListStringForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::mapStringOrListString( 'not an array' );
    }


    public function testMapStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::mapStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        self::expectException( TypeException::class );
        TypeIs::mapStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testMapStringyForNotArray() : void {
        self::expectException( TypeException::class );
        TypeIs::mapStringy( 'not an array' );
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
        $stringable = self::stringable();
        self::assertSame( $stringable, TypeIs::stringy( $stringable ) );
        self::assertSame( 'foo', TypeIs::stringy( 'foo' ) );
        self::expectException( TypeException::class );
        TypeIs::stringy( 123 );
    }


    public function testStringyOrNull() : void {
        $stringable = self::stringable();
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


    /**
     * @param list<mixed> $i_rValues
     * @return iterable<mixed>
     */
    private function generator( array $i_rValues ) : iterable {
        foreach ( $i_rValues as $value ) {
            yield $value;
        }
    }


    private function stringable() : Stringable {
        return new class implements Stringable {


            public function __toString() : string {
                return 'stringable';
            }


        };
    }


}
