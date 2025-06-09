<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\OK;
use JDWX\Strict\TypeException;
use PHPUnit\Framework\TestCase;


class OKTest extends TestCase {


    public function testFileGetContents() : void {
        self::assertIsString( OK::file_get_contents( __FILE__ ) );
        self::expectException( TypeException::class );
        OK::file_get_contents( '/no/such/file' );
    }


    public function testFilePutContents() : void {
        $tempFile = tempnam( sys_get_temp_dir(), 'test' );
        self::assertSame( 9, OK::file_put_contents( $tempFile, 'test data' ) );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::file_put_contents( '/no/such/file', 'data' );
    }


    public function testPregMatch() : void {
        self::assertSame( 1, OK::preg_match( '/test/', 'this is a test' ) );
        self::expectException( TypeException::class );
        OK::preg_match( '/test#', 'this is a test', $matches, 0, 0 );
    }


    public function testStrToTime() : void {
        self::assertIsInt( OK::strtotime( 'now' ) );
        self::expectException( TypeException::class );
        OK::strtotime( 'invalid date string' );
    }


}