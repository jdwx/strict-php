<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Cast;
use JDWX\Strict\Exceptions\TypeException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( Cast::class )]
final class CastTest extends TestCase {


    /** @suppress PhanTypeMismatchArgument */
    public function testArrayString() : void {
        self::assertSame( [ 'foo', 'bar' ], Cast::arrayString( [ 'foo', 'bar' ] ) );
        self::assertSame( [ 'foo', 'baz' => 'bar' ], Cast::arrayString( [ 'foo', 'baz' => 'bar' ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::arrayString( [ 1, 2, 3 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testArrayStringOrArrayString() : void {
        $r = [ 'foo', [ 'bar', 'baz' => 'qux' ] ];
        self::assertSame( $r, Cast::arrayStringOrArrayString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::arrayStringOrArrayString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testArrayStringOrListString() : void {
        self::assertSame( [ 'foo', [ 'bar', 'baz' ] ], Cast::arrayStringOrListString( [ 'foo', [ 'bar', 'baz' ] ] ) );
        self::assertSame(
            [ 'foo', 'bar' => [ 'baz', 'quux' ] ],
            Cast::arrayStringOrListString( [ 'foo', 'bar' => [ 'baz', 'qux' => 'quux' ] ] )
        );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::arrayStringOrListString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testArrayStringOrMapString() : void {
        $r = [ 'foo', [ 'bar' => 'baz', 'qux' ] ];
        self::assertSame( $r, Cast::arrayStringOrMapString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::arrayStringOrMapString( [ 1 ] );
    }


    public function testList() : void {
        self::assertSame( [ 1, 2.34, 'three' ], Cast::list( [ 1, 2.34, 'three' ] ) );
        self::assertSame( [ 1, 2.34, 'three' ], Cast::list( [ 1, 'foo' => 2.34, 'three' ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListFloat() : void {
        self::assertSame( [ 1.23, 2.34, 3.45 ], Cast::listFloat( [ 1.23, 2.34, 3.45 ] ) );
        self::assertSame( [ 1.23, 2.34, 3.45 ], Cast::listFloat( [ 1.23, 'foo' => 2.34, 3.45 ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listFloat( [ 'not a float' ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListInt() : void {
        self::assertSame( [ 1, 2, 3 ], Cast::listInt( [ 1, 2, 3 ] ) );
        self::assertSame( [ 1, 2, 3 ], Cast::listInt( [ 1, 'foo' => 2, 3 ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listInt( [ 'not an int' ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListNullableString() : void {
        self::assertSame( [ 'a', 'b', null ], Cast::listNullableString( [ 'a', 'b', null ] ) );
        self::assertSame( [ 'a', 'b', null ], Cast::listNullableString( [ 'a', 'foo' => 'b', null ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listNullableString( [ new \stdClass() ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListNullableStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'a';
            }


        };
        self::assertSame( [ 'a', $str, null ], Cast::listNullableStringy( [ 'a', $str, null ] ) );
        self::assertSame( [ 'a', $str, null ], Cast::listNullableStringy( [ 'a', 'foo' => $str, null ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listNullableStringy( [ 1.23 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListString() : void {
        self::assertSame( [ 'a', 'b', 'c' ], Cast::listString( [ 'a', 'b', 'c' ] ) );
        self::assertSame( [ 'a', 'b', 'c' ], Cast::listString( [ 'a', 'foo' => 'b', 'c' ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringOrArrayString() : void {
        $r = [ 'foo', [ 'bar', 'baz' => 'qux' ] ];
        self::assertSame( $r, Cast::listStringOrArrayString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listStringOrArrayString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringOrListString() : void {
        self::assertSame( [ 'a', [ 'b', 'c' ] ], Cast::listStringOrListString( [ 'a', [ 'b', 'c' ] ] ) );
        self::assertSame( [ 'a', [ 'b', 'c' ] ], Cast::listStringOrListString(
            [ 'a', 'foo' => [ 'b', 'bar' => 'c' ] ]
        ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listStringOrListString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringOrMapString() : void {
        $r = [ 'foo', [ 'bar' => 'baz', 'qux' ] ];
        self::assertSame( $r, Cast::listStringOrMapString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listStringOrMapString( [ 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'a';
            }


        };
        self::assertSame( [ 'a', 'b', $str ], Cast::listStringy( [ 'a', 'b', $str ] ) );
        self::assertSame( [ 'a', 'b', $str ], Cast::listStringy( [ 'a', 'foo' => 'b', $str ] ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::listStringy( [ 1 ] );
    }


    public function testMap() : void {
        $r = [ 'foo' => 'Foo!', 'bar' => 123, 'baz' => null ];
        self::assertSame( $r, Cast::map( $r ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapFloat() : void {
        $r = [ 'foo' => 1.23, 'bar' => 2.34 ];
        self::assertSame( $r, Cast::mapFloat( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapFloat( [ 'foo' => 'not a float' ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapInt() : void {
        $r = [ 'foo' => 1, 'bar' => 2 ];
        self::assertSame( $r, Cast::mapInt( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapInt( [ 'foo' => 'not an int' ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapNullableString() : void {
        $r = [ 'foo' => 'foo', 'bar' => null ];
        self::assertSame( $r, Cast::mapNullableString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapString( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapNullableStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'Bar!';
            }


        };
        $r = [ 'foo' => 'Foo!', 'bar' => $str, 'baz' => null ];
        self::assertSame( $r, Cast::mapNullableStringy( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapNullableStringy( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapString() : void {
        $r = [ 'foo' => 'foo', 'bar' => 'bar' ];
        self::assertSame( $r, Cast::mapString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapString( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringOrArrayString() : void {
        $r = [ 'foo' => 'bar', 'bar' => [ 'baz', 'qux' => 'quux' ] ];
        self::assertSame( $r, Cast::mapStringOrArrayString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapStringOrArrayString( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringOrListString() : void {
        $r = [ 'foo' => 'foo', 'bar' => [ 'bar1', 'bar2' ] ];
        self::assertSame( $r, Cast::mapStringOrListString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapStringOrListString( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringOrMapString() : void {
        $r = [ 'foo' => 'bar', 'bar' => [ 'baz' => 'qux', 'quux' => 'corge' ] ];
        self::assertSame( $r, Cast::mapStringOrMapString( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapStringOrMapString( [ 'foo' => 1 ] );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'Bar!';
            }


        };
        $r = [ 'foo' => 'Foo!', 'bar' => $str ];
        self::assertSame( $r, Cast::mapStringy( $r ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        Cast::mapStringy( [ 'foo' => 1 ] );
    }


}
