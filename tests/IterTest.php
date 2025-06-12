<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Exceptions\TypeException;
use JDWX\Strict\Iter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( Iter::class )]
final class IterTest extends TestCase {


    public function testList() : void {
        self::assertSame( [ 1, 2.34, 'three' ], iterator_to_array( Iter::list( [ 1, 2.34, 'three' ] ) ) );
        self::assertSame( [ 1, 2.34, 'three' ], iterator_to_array( Iter::list( [ 1, 'foo' => 2.34, 'three' ] ) ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListFloat() : void {
        self::assertSame( [ 1.23, 2.34, 3.45 ], iterator_to_array( Iter::listFloat( [ 1.23, 2.34, 3.45 ] ) ) );
        self::assertSame( [ 1.23, 2.34, 3.45 ], iterator_to_array( Iter::listFloat( [ 1.23, 'foo' => 2.34, 3.45 ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listFloat( [ 'not a float' ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListInt() : void {
        self::assertSame( [ 1, 2, 3 ], iterator_to_array( Iter::listInt( [ 1, 2, 3 ] ) ) );
        self::assertSame( [ 1, 2, 3 ], iterator_to_array( Iter::listInt( [ 1, 'foo' => 2, 3 ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listInt( [ 'not an int' ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListString() : void {
        self::assertSame( [ 'a', 'b', 'c' ], iterator_to_array( Iter::listString( [ 'a', 'b', 'c' ] ) ) );
        self::assertSame( [ 'a', 'b', 'c' ], iterator_to_array( Iter::listString( [ 'a', 'foo' => 'b', 'c' ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listString( [ 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringOrNull() : void {
        self::assertSame( [ 'a', 'b', null ], iterator_to_array( Iter::listNullableString( [ 'a', 'b', null ] ) ) );
        self::assertSame( [ 'a', 'b', null ], iterator_to_array( Iter::listNullableString( [ 'a', 'foo' => 'b', null ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listNullableString( [ new \stdClass() ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringOrStringList() : void {
        self::assertSame( [ 'a', [ 'b', 'c' ] ], iterator_to_array(
            Iter::listStringOrStringList( [ 'a', [ 'b', 'c' ] ] )
        ) );
        self::assertSame( [ 'a', [ 'b', 'c' ] ], iterator_to_array(
            Iter::listStringOrStringList( [ 'a', 'foo' => [ 'b', 'bar' => 'c' ] ] )
        ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listStringOrStringList( [ 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'a';
            }


        };
        self::assertSame( [ 'a', 'b', $str ], iterator_to_array( Iter::listStringy( [ 'a', 'b', $str ] ) ) );
        self::assertSame( [ 'a', 'b', $str ], iterator_to_array( Iter::listStringy( [ 'a', 'foo' => 'b', $str ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listStringy( [ 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testListStringyOrNull() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'a';
            }


        };
        self::assertSame( [ 'a', $str, null ], iterator_to_array( Iter::listNullableStringy( [ 'a', $str, null ] ) ) );
        self::assertSame( [ 'a', $str, null ], iterator_to_array( Iter::listNullableStringy( [ 'a', 'foo' => $str, null ] ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::listNullableStringy( [ 1.23 ] ) );
    }


    public function testMap() : void {
        $it = Iter::map( [ 'foo' => 'Foo!', 'bar' => 'Bar!' ] );

        self::assertSame( 'foo', $it->key() );
        self::assertSame( 'Foo!', $it->current() );
        $it->next();
        self::assertSame( 'bar', $it->key() );
        self::assertSame( 'Bar!', $it->current() );
        $it->next();
        self::assertFalse( $it->valid() );

        $r = [ 'foo' => 'Foo!', '1' => 'One!' ];
        self::assertSame( [ 'foo' => 'Foo!', 1 => 'One!' ], $r );
        $it = Iter::map( $r );
        self::assertSame( 'foo', $it->key() );
        self::assertSame( 'Foo!', $it->current() );
        $it->next();
        self::assertSame( '1', $it->key() );
        self::assertSame( 'One!', $it->current() );
        $it->next();
        self::assertFalse( $it->valid() );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapFloat() : void {
        $r = [ 'foo' => 1.23, 'bar' => 2.34 ];
        self::assertSame( $r, iterator_to_array( Iter::mapFloat( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapFloat( [ 'foo' => 'not a float' ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapInt() : void {
        $r = [ 'foo' => 1, 'bar' => 2 ];
        self::assertSame( $r, iterator_to_array( Iter::mapInt( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapInt( [ 'foo' => 'not an int' ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapString() : void {
        $r = [ 'foo' => 'foo', 'bar' => 'bar' ];
        self::assertSame( $r, iterator_to_array( Iter::mapString( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapString( [ 'foo' => 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringOrListString() : void {
        $r = [ 'foo' => 'a', 'bar' => [ 'b', 'c' ] ];
        self::assertSame( $r, iterator_to_array( Iter::mapStringOrListString( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapStringOrListString( [ 'foo' => 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringOrNull() : void {
        $r = [ 'foo' => 'foo', 'bar' => null ];
        self::assertSame( $r, iterator_to_array( Iter::mapNullableString( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapString( [ 'foo' => 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringy() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'Bar!';
            }


        };
        $r = [ 'foo' => 'Foo!', 'bar' => $str ];
        self::assertSame( $r, iterator_to_array( Iter::mapStringy( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapStringy( [ 'foo' => 1 ] ) );
    }


    /** @suppress PhanTypeMismatchArgument */
    public function testMapStringyOrNull() : void {
        $str = new class implements \Stringable {


            public function __toString() : string {
                return 'Bar!';
            }


        };
        $r = [ 'foo' => 'Foo!', 'bar' => $str, 'baz' => null ];
        self::assertSame( $r, iterator_to_array( Iter::mapNullableStringy( $r ) ) );
        self::expectException( TypeException::class );
        /** @phpstan-ignore argument.type */
        iterator_to_array( Iter::mapNullableStringy( [ 'foo' => 1 ] ) );


    }


}
