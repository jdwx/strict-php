<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Convert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stringable;


#[CoversClass( Convert::class )]
final class ConvertTest extends TestCase {


    public function testList() : void {
        $f = 3.14159;
        self::assertSame( [ 'a', 1, $f ], Convert::list( [ 'a', 1, $f ] ) );
        self::assertSame( [ 'a' ], Convert::list( 'a' ) );
        self::assertSame( [ $f ], Convert::list( $f ) );
    }


    public function testListOrInt() : void {
        self::assertSame( [ 1, 2, 3 ], Convert::listOrInt( [ 1, 2, 3 ] ) );
        self::assertSame( [ 1 ], Convert::listOrInt( 1 ) );
    }


    public function testListOrString() : void {
        self::assertSame( [ 'a', 'b', 'c' ], Convert::listOrString( [ 'a', 'b', 'c' ] ) );
        self::assertSame( [ 'a' ], Convert::listOrString( 'a' ) );
    }


    public function testListOrStringy() : void {
        self::assertSame( [ 'a', 'b', 'c' ], Convert::listOrStringy( [ 'a', 'b', 'c' ] ) );
        self::assertSame( [ 'a' ], Convert::listOrStringy( 'a' ) );
        $str = new class implements Stringable {


            public function __toString() : string {
                return 'a';
            }


        };
        self::assertSame( [ $str ], Convert::listOrStringy( $str ) );
    }


}
