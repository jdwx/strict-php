<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Exceptions\TypeException;
use JDWX\Strict\Exceptions\UnexpectedFailureException;
use JDWX\Strict\OK;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( OK::class )]
final class OKTest extends TestCase {


    public function testFClose() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        self::assertTrue( OK::fclose( $fh ) );
        # I do not know of a way to provoke fclose() to return false in a test environment.
    }


    public function testFGets() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::fgets( $fh ) );
        fclose( $fh );

        $tempFile = tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'w' );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::fgets( $fh );
    }


    public function testFOpen() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        self::assertIsResource( $fh );
        fclose( $fh );
        self::expectException( TypeException::class );
        OK::fopen( '/no/such/file', 'r' );
    }


    public function testFRead() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::fread( $fh, 10 ) );
        fclose( $fh );

        $tempFile = tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'w' );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::fread( $fh, 10 );
    }


    public function testFWrite() : void {
        $tempFile = tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'w' );
        self::assertIsResource( $fh );
        unlink( $tempFile );
        self::assertSame( 9, OK::fwrite( $fh, 'test data' ) );
        fclose( $fh );

        $tempFile = tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'r' );
        self::assertIsResource( $fh );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::fwrite( $fh, 'test data' );
    }


    public function testFileGetContents() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
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


    public function testJsonDecode() : void {
        self::assertIsArray( OK::json_decode( '{"a":1,"b":2}', true ) );
        self::expectException( UnexpectedFailureException::class );
        OK::json_decode( 'invalid json' );
    }


    public function testPregMatch() : void {
        self::assertSame( 1, OK::preg_match( '/test/', 'this is a test' ) );
        self::expectException( UnexpectedFailureException::class );
        OK::preg_match( '/test#', 'this is a test', $matches );
    }


    public function testStrToTime() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsInt( OK::strtotime( 'now' ) );
        self::expectException( TypeException::class );
        OK::strtotime( 'invalid date string' );
    }


}