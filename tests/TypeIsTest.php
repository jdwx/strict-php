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


    private static function stringable() : Stringable {
        return new class implements Stringable {


            public function __toString() : string {
                return 'stringable';
            }


        };
    }


    public function testArray() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsArray( TypeIs::array( [] ) );
        $this->expectException( TypeException::class );
        TypeIs::array( 'not an array' );
    }


    public function testArrayNullableString() : void {
        self::assertSame( [ 'foo', null ], TypeIs::arrayNullableString( [ 'foo', null ] ) );
        $this->expectException( TypeException::class );
        TypeIs::arrayNullableString( [ 'foo', 123 ] );
    }


    public function testArrayNullableStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayNullableString( 'not an array' );
    }


    public function testArrayNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::arrayNullableStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        $this->expectException( TypeException::class );
        TypeIs::arrayNullableStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testArrayNullableStringyForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayNullableStringy( 'not an array' );
    }


    public function testArrayOrNull() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayOrNull( [ 'foo', 'bar' ] ) );
        self::assertNull( TypeIs::arrayOrNull( null ) );
        $this->expectException( TypeException::class );
        TypeIs::arrayOrNull( 'not an array or null' );
    }


    public function testArrayString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayString( [ 'foo', 'bar' ] ) );
        $this->expectException( TypeException::class );
        TypeIs::arrayString( [ 'foo', 123 ] );
    }


    public function testArrayStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayString( 'not an array' );
    }


    public function testArrayStringOrArrayString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayStringOrArrayString( [ 'foo', 'bar' ] ) );

        $r = [ 'foo' => 'bar', 'baz' => 'qux' ];
        self::assertSame( $r, TypeIs::arrayStringOrArrayString( $r ) );

        $r = [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ];
        self::assertSame( $r, TypeIs::arrayStringOrArrayString( $r ) );

        $r = [ 'foo', 'bar', 'baz' => [ 'qux', 'quux' => 'corge' ] ];
        self::assertSame( $r, TypeIs::arrayStringOrArrayString( $r ) );

        $this->expectException( TypeException::class );
        TypeIs::arrayStringOrArrayString( [ 'foo' => 33 ] );
    }


    public function testArrayStringOrArrayStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayStringOrArrayString( 'not an array' );
    }


    public function testArrayStringOrListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::arrayStringOrListString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], TypeIs::arrayStringOrListString( [ 'foo', [ 'bar', 'baz' ] ] ) );
        $this->expectException( TypeException::class );
        TypeIs::arrayStringOrListString( 123 );
    }


    public function testArrayStringOrListStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayStringOrListString( 'not an array' );
    }


    public function testArrayStringy() : void {
        $stringable = self::stringable();
        self::assertSame( [ 'foo', $stringable ], TypeIs::arrayStringy( [ 'foo', $stringable ] ) );
        $this->expectException( TypeException::class );
        TypeIs::arrayStringy( [ 'foo', 123 ] );
    }


    public function testArrayStringyForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::arrayStringy( 'not an array' );
    }


    public function testBool() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsBool( TypeIs::bool( true ) );
        $this->expectException( TypeException::class );
        TypeIs::bool( 'not a bool' );
    }


    public function testCallable() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsCallable( TypeIs::callable( function () {} ) );
        $this->expectException( TypeException::class );
        TypeIs::callable( 'not callable' );
    }


    public function testFloat() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsFloat( TypeIs::float( 1.23 ) );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsFloat( TypeIs::float( 123 ) ); # implicit int-to-float conversion even for strict types
        $this->expectException( TypeException::class );
        TypeIs::float( 'not a float' );
    }


    public function testInt() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsInt( TypeIs::int( 123 ) );
        $this->expectException( TypeException::class );
        TypeIs::int( 'not an int' );
    }


    public function testIterable() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterable( $it ) ) );
        $this->expectException( TypeException::class );
        TypeIs::iterable( 'not iterable' );
    }


    public function testIterableNullableString() : void {
        $it = $this->generator( [ 'foo', null ] );
        self::assertSame( [ 'foo', null ], iterator_to_array( TypeIs::iterableNullableString( $it ) ) );
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableString( [ 'foo', 123 ] ) );
    }


    public function testIterableNullableStringForNotIterable() : void {
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableString( 123 ) );
    }


    public function testIterableNullableStringy() : void {
        $stringable = self::stringable();
        $it = $this->generator( [ 'foo', $stringable ] );
        self::assertSame( [ 'foo', $stringable ], iterator_to_array( TypeIs::iterableNullableStringy( $it ) ) );
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableStringy( [ 'foo', 123 ] ) );
    }


    public function testIterableNullableStringyForNotIterable() : void {
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableNullableStringy( 123 ) );
    }


    public function testIterableString() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterableString( $it ) ) );
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableString( [ 'baz', 123 ] ) );
    }


    public function testIterableStringForNotIterable() : void {
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableString( 123 ) );
    }


    public function testIterableStringOrArrayString() : void {
        $r = [ 'foo' => 'bar', 'baz' => 'qux' ];
        $it = $this->generator( $r );
        self::assertSame( $r, iterator_to_array( TypeIs::iterableStringOrArrayString( $it ) ) );

        $r = [ 'foo' => 'bar', 'baz' => [ 'qux' => 'quux' ] ];
        $it = $this->generator( $r );
        self::assertSame( $r, iterator_to_array( TypeIs::iterableStringOrArrayString( $it ) ) );

        $r = [ 'foo', 'bar', 'baz' => [ 'qux', 'quux' => 'corge' ] ];
        $it = $this->generator( $r );
        self::assertSame( $r, iterator_to_array( TypeIs::iterableStringOrArrayString( $it ) ) );

        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrArrayString( 123 ) );
    }


    public function testIterableStringOrListString() : void {
        $it = $this->generator( [ 'foo', 'bar' ] );
        self::assertSame( [ 'foo', 'bar' ], iterator_to_array( TypeIs::iterableStringOrListString( $it ) ) );
        $it = $this->generator( [ 'foo', [ 'bar', 'baz' ] ] );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], iterator_to_array( TypeIs::iterableStringOrListString( $it ) ) );
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrListString( 123 ) );
    }


    public function testIterableStringOrListStringForNotIterable() : void {
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrListString( 'not iterable' ) );
    }


    public function testIterableStringOrMapString() : void {
        $r = [ 'foo' => 'bar', 'baz' => 'qux' ];
        $it = $this->generator( $r );
        self::assertSame( $r, iterator_to_array( TypeIs::iterableStringOrMapString( $it ) ) );

        $r = [ 'foo' => 'bar', 'baz' => [ 'qux' => 'quux' ] ];
        $it = $this->generator( $r );
        self::assertSame( $r, iterator_to_array( TypeIs::iterableStringOrMapString( $it ) ) );

        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringOrMapString( 123 ) );
    }


    public function testIterableStringy() : void {
        $stringable = self::stringable();
        $it = $this->generator( [ 'foo', $stringable ] );
        self::assertSame( [ 'foo', $stringable ], iterator_to_array( TypeIs::iterableStringy( $it ) ) );
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringy( [ 'foo', 123 ] ) );
    }


    public function testIterableStringyForNotIterable() : void {
        $this->expectException( TypeException::class );
        iterator_to_array( TypeIs::iterableStringy( 123 ) );
    }


    public function testListNullableString() : void {
        self::assertSame( [ 'foo', null ], TypeIs::listNullableString( [ 'foo', null ] ) );
        $this->expectException( TypeException::class );
        $this->expectExceptionMessage( '?string value' );
        self::assertSame( [ 'foo', null ], TypeIs::listNullableString( [ 'foo', 123 ] ) );
    }


    public function testListNullableStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::listNullableString( 'not an array' );
    }


    public function testListNullableStringForStringKey() : void {
        $this->expectException( TypeException::class );
        $this->expectExceptionMessage( 'int key' );
        TypeIs::listNullableString( [ 'foo', 'bar' => null ] );
    }


    public function testListNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo', $stringable ],
            iterator_to_array( TypeIs::listNullableStringy( [ 'foo', $stringable ] ) )
        );
        $this->expectException( TypeException::class );
        self::assertSame( [ 'foo', $stringable ], TypeIs::listNullableStringy( [ 'foo', 123 ] ) );
    }


    public function testListNullableStringyForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::listNullableStringy( 'not an array' );
    }


    public function testListNullableStringyForStringKey() : void {
        $this->expectException( TypeException::class );
        $this->expectExceptionMessage( 'int key' );
        TypeIs::listNullableStringy( [ 'foo', 'bar' => null ] );
    }


    public function testListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listString( [ 'foo', 'bar' ] ) );
        $this->expectException( TypeException::class );
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listString( [ 'foo', 'baz' => 'bar' ] ) );
    }


    public function testListStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::listString( 'not an array' );
    }


    public function testListStringForValueNotString() : void {
        $this->expectException( TypeException::class );
        TypeIs::listString( [ 'foo', 123 ] );
    }


    public function testListStringOrListString() : void {
        self::assertSame( [ 'foo', 'bar' ], TypeIs::listStringOrListString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], TypeIs::listStringOrListString( [ 'foo', [ 'bar', 'baz' ] ] ) );
        $this->expectException( TypeException::class );
        TypeIs::listStringOrListString( [ 123 ] );
    }


    public function testListStringOrListStringForKeyNotInt() : void {
        $this->expectException( TypeException::class );
        TypeIs::listStringOrListString( [ 'foo' => 'bar' ] );
    }


    public function testListStringOrListStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::listStringOrListString( 'not an array' );
    }


    public function testListStringy() : void {
        $stringable = self::stringable();
        self::assertSame( [ 'foo', $stringable ], TypeIs::listStringy( [ 'foo', $stringable ] ) );
        $this->expectException( TypeException::class );
        self::assertSame( [ 'foo', $stringable ], TypeIs::listStringy( [ 'foo', 123 ] ) );
    }


    public function testListStringyForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::listStringy( 'not an array' );
    }


    public function testListStringyForStringKey() : void {
        $stringable = self::stringable();
        $this->expectException( TypeException::class );
        $this->expectExceptionMessage( 'int key' );
        TypeIs::listStringy( [ 'foo', 'bar' => $stringable ] );
    }


    public function testMapNullableString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => null ], TypeIs::mapNullableString( [ 'foo' => 'bar', 'baz' => null ] ) );
        $this->expectException( TypeException::class );
        TypeIs::mapNullableString( [ 'foo' => 123, 'baz' => null ] );
    }


    public function testMapNullableStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::mapNullableString( 'not an array' );
    }


    public function testMapNullableStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::mapNullableStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        $this->expectException( TypeException::class );
        TypeIs::mapNullableStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testMapString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => 'qux' ], TypeIs::mapString( [ 'foo' => 'bar', 'baz' => 'qux' ] ) );
        $this->expectException( TypeException::class );
        TypeIs::mapString( [ 'foo' => 123, 'baz' => 'qux' ] );
    }


    public function testMapStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::mapString( 'not an array' );
    }


    public function testMapStringOrArrayString() : void {
        $r = [ 'foo' => 'bar', 'baz' => 'qux' ];
        self::assertSame( $r, TypeIs::mapStringOrArrayString( $r ) );

        $r = [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ];
        self::assertSame( $r, TypeIs::mapStringOrArrayString( $r ) );

        # Map cannot require keys to be strings, just wish really hard,
        # so this is (unfortunately) valid:
        $r = [ 'foo', 'bar', 'baz' => [ 'qux', 'quux' => 'corge' ] ];
        self::assertSame( $r, TypeIs::mapStringOrArrayString( $r ) );

        $this->expectException( TypeException::class );
        TypeIs::mapStringOrArrayString( [ 'foo' => 123, 'baz' => 'qux' ] );
    }


    public function testMapStringOrListString() : void {
        self::assertSame( [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ], TypeIs::mapStringOrListString( [ 'foo' => 'bar', 'baz' => [ 'qux', 'quux' ] ] ) );
        $this->expectException( TypeException::class );
        TypeIs::mapStringOrListString( [ 'foo' => 123, 'baz' => [ 'qux', 'quux' ] ] );
    }


    public function testMapStringOrListStringForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::mapStringOrListString( 'not an array' );
    }


    public function testMapStringy() : void {
        $stringable = self::stringable();
        self::assertSame(
            [ 'foo' => 'bar', 'baz' => $stringable ],
            TypeIs::mapStringy( [ 'foo' => 'bar', 'baz' => $stringable ] )
        );
        $this->expectException( TypeException::class );
        TypeIs::mapStringy( [ 'foo' => 123, 'baz' => $stringable ] );
    }


    public function testMapStringyForNotArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::mapStringy( 'not an array' );
    }


    public function testObject() : void {
        self::assertSame( $this, TypeIs::object( $this ) );
        $this->expectException( TypeException::class );
        TypeIs::object( 'not an object' );
    }


    public function testResource() : void {
        self::assertIsResource( TypeIs::resource( fopen( __FILE__, 'rb' ) ) );
        $this->expectException( TypeException::class );
        TypeIs::resource( 'not a resource' );
    }


    public function testSocket() : void {
        $sock = socket_create( AF_INET, SOCK_STREAM, 0 );
        self::assertSame( $sock, TypeIs::socket( $sock ) );

        $this->expectException( TypeException::class );
        TypeIs::socket( 5 );
    }


    public function testString() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( TypeIs::string( 'test' ) );
        $this->expectException( TypeException::class );
        TypeIs::string( 123 );
    }


    public function testStringOrArrayString() : void {
        self::assertSame( 'foo', TypeIs::stringOrArrayString( 'foo' ) );
        self::assertSame( [ 'foo', 'bar' ], TypeIs::stringOrArrayString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', 'bar' => 'baz' ], TypeIs::stringOrArrayString( [ 'foo', 'bar' => 'baz' ] ) );
        $this->expectException( TypeException::class );
        TypeIs::stringOrArrayString( 123 );
    }


    public function testStringOrArrayStringForBadArrayValue() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrArrayString( [ 'foo' => 123 ] );
    }


    public function testStringOrArrayStringForNestedArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrArrayString( [ 'foo' => [ 'bar' => 'baz' ] ] );
    }


    public function testStringOrListString() : void {
        self::assertSame( 'foo', TypeIs::stringOrListString( 'foo' ) );
        self::assertSame( [ 'foo', 'bar' ], TypeIs::stringOrListString( [ 'foo', 'bar' ] ) );
        $this->expectException( TypeException::class );
        TypeIs::stringOrListString( 123 );
    }


    public function testStringOrListStringForBadArrayValue() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrListString( [ 'foo', 123 ] );
    }


    public function testStringOrListStringForNestedArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrListString( [ 'foo' => [ 'bar', 'baz' ] ] );
    }


    public function testStringOrListStringForStringKey() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrListString( [ 'foo' => 'bar' ] );
    }


    public function testStringOrMapString() : void {
        self::assertSame( 'foo', TypeIs::stringOrMapString( 'foo' ) );
        $r = [ 'foo' => 'bar', 'baz' => 'qux' ];
        self::assertSame( $r, TypeIs::stringOrMapString( $r ) );
        $this->expectException( TypeException::class );
        TypeIs::stringOrMapString( 123 );
    }


    public function testStringOrMapStringForBadArrayValue() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrMapString( [ 'foo' => 123 ] );
    }


    public function testStringOrMapStringForNestedArray() : void {
        $this->expectException( TypeException::class );
        TypeIs::stringOrMapString( [ 'foo' => [ 'bar' => 'baz' ] ] );
    }


    public function testStringOrNull() : void {
        self::assertSame( 'foo', TypeIs::stringOrNull( 'foo' ) );
        self::assertNull( TypeIs::stringOrNull( null ) );
        $this->expectException( TypeException::class );
        TypeIs::stringOrNull( 123 );
    }


    public function testStringy() : void {
        $stringable = self::stringable();
        self::assertSame( $stringable, TypeIs::stringy( $stringable ) );
        self::assertSame( 'foo', TypeIs::stringy( 'foo' ) );
        $this->expectException( TypeException::class );
        TypeIs::stringy( 123 );
    }


    public function testStringyOrNull() : void {
        $stringable = self::stringable();
        self::assertSame( 'foo', TypeIs::stringyOrNull( 'foo' ) );
        self::assertSame( $stringable, TypeIs::stringyOrNull( $stringable ) );
        self::assertNull( TypeIs::stringyOrNull( null ) );
        $this->expectException( TypeException::class );
        TypeIs::stringyOrNull( false );
    }


    public function testTrue() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( TypeIs::true( true ) );
        $this->expectException( TypeException::class );
        TypeIs::true( 'not a bool' );
    }


    /**
     * @param array<mixed> $i_rValues
     * @return iterable<mixed>
     */
    private function generator( array $i_rValues ) : iterable {
        foreach ( $i_rValues as $key => $value ) {
            yield $key => $value;
        }
    }


}
