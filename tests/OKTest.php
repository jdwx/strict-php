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

        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
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

        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'w' );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::fread( $fh, 10 );
    }


    public function testFWrite() : void {
        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
        $fh = OK::fopen( $tempFile, 'w' );
        self::assertIsResource( $fh );
        unlink( $tempFile );
        self::assertSame( 9, OK::fwrite( $fh, 'test data' ) );
        fclose( $fh );

        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
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
        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
        self::assertSame( 9, OK::file_put_contents( $tempFile, 'test data' ) );
        unlink( $tempFile );
        self::expectException( TypeException::class );
        OK::file_put_contents( '/no/such/file', 'data' );
    }


    public function testHttpResponseCode() : void {
        # Since PHPUnit doesn't run under a web server, we cannot test
        # the successful case of http_response_code(). But it's happy
        # to fail for us!
        self::expectException( TypeException::class );
        OK::http_response_code();
    }


    public function testIniGet() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::ini_get( 'display_errors' ) );
        self::expectException( TypeException::class );
        OK::ini_get( 'no_such_value' );
    }


    public function testIniSet() : void {
        $oldValue = OK::ini_set( 'display_errors', '1' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( $oldValue );
        // Reset to the old value
        OK::ini_set( 'display_errors', $oldValue );
        self::expectException( TypeException::class );
        OK::ini_set( 'no_such_value', 'foo' );
    }


    public function testJsonDecode() : void {
        self::assertIsArray( OK::json_decode( '{"a":1,"b":2}', true ) );
        self::expectException( UnexpectedFailureException::class );
        OK::json_decode( 'invalid json' );
    }


    public function testOutputBuffering() : void {
        # Most of these fall into the "can't test failure" category, especially
        # since PHPUnit is already using output buffering.
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( OK::ob_start() );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( OK::ob_clean() );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( OK::ob_flush() );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( OK::ob_end_flush() );

        OK::ob_start();
        echo 'Foo';
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertTrue( OK::ob_end_clean() );

        OK::ob_start();
        echo 'Bar';
        self::assertSame( 'Bar', OK::ob_get_contents() );
        self::assertSame( 3, OK::ob_get_length() );
        self::assertSame( 'Bar', OK::ob_get_clean() );

        OK::ob_start();
        echo 'Baz';
        self::assertSame( 'Baz', OK::ob_get_flush() );
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


    /**
     * Tests tempnam() but, by necessity, also tests ini_set().
     */
    public function testTempNam() : void {
        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( $tempFile );
        # This is another that I do not know how to provoke an exception for.
        # If the target directory does not exist, tempnam() falls back to
        # the system's temporary directory.
        self::expectException( TypeException::class );
        $oldTemp = OK::ini_set( 'sys_temp_dir', '/no/such/path' );
        try {
            OK::tempnam( __DIR__, 'test' );
        } catch ( TypeException $e ) {
            OK::ini_set( 'sys_temp_dir', $oldTemp );
            throw $e;
        }
    }


}