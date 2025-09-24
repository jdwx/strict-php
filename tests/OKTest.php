<?php /** @noinspection PhpComposerExtensionStubsInspection */


declare( strict_types = 1 );


namespace JDWX\Strict\Tests;


use JDWX\Strict\Exceptions\TypeException;
use JDWX\Strict\Exceptions\UnexpectedFailureException;
use JDWX\Strict\OK;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( OK::class )]
final class OKTest extends TestCase {


    public function testBase64Decode() : void {
        self::assertSame( 'test data', OK::base64_decode( 'dGVzdCBkYXRh' ) );
        $this->expectException( TypeException::class );
        OK::base64_decode( '**invalid base64**', true );
    }


    public function testDirectoryFunctions() : void {
        $x = OK::opendir( __DIR__ );
        OK::rewinddir( $x );
        $r = [];
        while ( false !== ( $entry = OK::readdir( $x ) ) ) {
            $r[] = $entry;
        }
        OK::closedir( $x );
        self::assertContains( '.', $r );
        self::assertContains( '..', $r );
        self::assertContains( basename( __FILE__ ), $r );

        $this->expectException( TypeException::class );
        OK::opendir( '/no/such/dir' );
    }


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
        $this->expectException( TypeException::class );
        OK::fgets( $fh );
    }


    public function testFOpen() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        self::assertIsResource( $fh );
        fclose( $fh );
        $this->expectException( TypeException::class );
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
        $this->expectException( TypeException::class );
        OK::fread( $fh, 10 );
    }


    public function testFSockOpen() : void {
        $socket = OK::socket_create( AF_INET, SOCK_DGRAM, 0 );
        OK::socket_bind( $socket, '127.0.0.1' );
        OK::socket_getsockname( $socket, $address, $port );
        assert( is_int( $port ) );
        self::assertGreaterThan( 0, $port );

        $fh = OK::fsockopen( 'udp://127.0.0.1', $port, $errno, $errstr );
        self::assertIsResource( $fh );
        fclose( $fh );
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
        $this->expectException( TypeException::class );
        OK::fwrite( $fh, 'test data' );
    }


    public function testFileGetContents() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::file_get_contents( __FILE__ ) );
        $this->expectException( TypeException::class );
        OK::file_get_contents( '/no/such/file' );
    }


    public function testFilePutContents() : void {
        $tempFile = OK::tempnam( sys_get_temp_dir(), 'test' );
        self::assertSame( 9, OK::file_put_contents( $tempFile, 'test data' ) );
        unlink( $tempFile );
        $this->expectException( TypeException::class );
        OK::file_put_contents( '/no/such/file', 'data' );
    }


    public function testHttpResponseCode() : void {
        # Since PHPUnit doesn't run under a web server, we cannot test
        # the successful case of http_response_code(). But it's happy
        # to fail for us!
        $this->expectException( TypeException::class );
        OK::http_response_code();
    }


    public function testInetNToP() : void {
        self::assertSame( '1.2.3.4', OK::inet_ntop( "\x01\x02\x03\x04" ) );
        self::assertSame(
            '::1',
            OK::inet_ntop( "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01" )
        );
        $this->expectException( TypeException::class );
        OK::inet_ntop( 'not an address' );
    }


    public function testInetPToN() : void {
        self::assertSame( "\x01\x02\x03\x04", OK::inet_pton( '1.2.3.4' ) );
        self::assertSame(
            "\x00\x05\x00\x00\x00\x00\x00\x00\x00\x04\x00\x03\x00\x02\x00\x01",
            OK::inet_pton( '5::4:3:2:1' )
        );
        $this->expectException( TypeException::class );
        OK::inet_pton( 'not an address' );
    }


    public function testIniGet() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::ini_get( 'display_errors' ) );
        $this->expectException( TypeException::class );
        OK::ini_get( 'no_such_value' );
    }


    public function testIniSet() : void {
        $oldValue = OK::ini_set( 'display_errors', '1' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( $oldValue );
        // Reset to the old value
        OK::ini_set( 'display_errors', $oldValue );
        $this->expectException( TypeException::class );
        OK::ini_set( 'no_such_value', 'foo' );
    }


    public function testJsonDecode() : void {
        self::assertIsArray( OK::json_decode( '{"a":1,"b":2}', true ) );
        $this->expectException( UnexpectedFailureException::class );
        OK::json_decode( 'invalid json' );
    }


    public function testMbConvertEncoding() : void {
        self::assertSame( 'test', OK::mb_convert_encoding( 'test', 'UTF-8' ) );
        # Another that I do not know how to provoke a failure for.
    }


    public function testMbConvertEncodingString() : void {
        self::assertSame( 'test', OK::mb_convert_encoding_string( 'test', 'UTF-8' ) );
        # Another that I do not know how to provoke a failure for.
    }


    public function testMkdir() : void {
        $tempDir = OK::tempnam( sys_get_temp_dir(), 'test' );
        unlink( $tempDir );
        self::assertDirectoryDoesNotExist( $tempDir );
        OK::mkdir( $tempDir );
        self::assertDirectoryExists( $tempDir );
        rmdir( $tempDir );

        $this->expectException( UnexpectedFailureException::class );
        OK::mkdir( '/no/such/path' );
    }


    public function testMkdirIfDoesNotExist() : void {
        $tempDir = OK::tempnam( sys_get_temp_dir(), 'test' );
        unlink( $tempDir );
        self::assertDirectoryDoesNotExist( $tempDir );
        OK::mkdirIfDoesNotExist( $tempDir );
        self::assertDirectoryExists( $tempDir );

        OK::mkdirIfDoesNotExist( $tempDir ); // Should not throw an exception
        rmdir( $tempDir );

        $this->expectException( UnexpectedFailureException::class );
        OK::mkdirIfDoesNotExist( '/no/such/path' );
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


    public function testPack() : void {
        $data = OK::pack( 'C*', 1, 2, 3, 4 );
        $r = unpack( 'C*', $data );
        assert( is_array( $r ) );
        self::assertSame( [ 1 => 1, 2 => 2, 3 => 3, 4 => 4 ], $r );
        # I don't think pack() can fail without throwing an exception.
    }


    public function testPregMatch() : void {
        self::assertSame( 1, OK::preg_match( '/test/', 'this is a test' ) );
        $this->expectException( UnexpectedFailureException::class );
        OK::preg_match( '/test#', 'this is a test', $matches );
    }


    public function testPregReplace() : void {
        self::assertSame(
            'this is a test',
            OK::preg_replace( '/test/', 'test', 'this is a test' )
        );
        $this->expectException( UnexpectedFailureException::class );
        OK::preg_replace( '/test#', 'test', 'this is a test' );
    }


    public function testPregReplaceCallback() : void {
        self::assertSame(
            'this is a test',
            OK::preg_replace_callback(
                '/test/',
                static function ( array $matches ) : string {
                    return $matches[ 0 ];
                },
                'this is a test'
            )
        );
        $this->expectException( UnexpectedFailureException::class );
        OK::preg_replace_callback( '/test#', static function ( array $matches ) : string {
            return $matches[ 0 ];
        }, 'this is a test' );
    }


    public function testPregReplaceCallbackString() : void {
        self::assertSame(
            'this is a test',
            OK::preg_replace_callback_string(
                '/test/',
                static function ( array $matches ) : string {
                    return $matches[ 0 ];
                },
                'this is a test'
            )
        );
        $this->expectException( UnexpectedFailureException::class );
        OK::preg_replace_callback_string( '/test#', static function ( array $matches ) : string {
            return $matches[ 0 ];
        }, 'this is a test' );
    }


    public function testPregReplaceString() : void {
        self::assertSame(
            'this is a test',
            OK::preg_replace_string( '/test/', 'test', 'this is a test' )
        );
        $this->expectException( UnexpectedFailureException::class );
        OK::preg_replace_string( '/test#', 'test', 'this is a test' );
    }


    public function testPregSplit() : void {
        $result = OK::preg_split( '/\s+/', 'this is a test' );
        self::assertSame( [ 'this', 'is', 'a', 'test' ], $result );

        $result = OK::preg_split( '/\s+/', 'this is a test', -1, PREG_SPLIT_OFFSET_CAPTURE );
        self::assertSame(
            [ [ 'this', 0 ], [ 'is', 5 ], [ 'a', 8 ], [ 'test', 10 ] ],
            $result
        );

        $this->expectException( UnexpectedFailureException::class );
        OK::preg_split( '/test#', 'this is a test' );
    }


    public function testPregSplitList() : void {
        $result = OK::preg_split_list( '/\s+/', 'this is a test' );
        self::assertSame( [ 'this', 'is', 'a', 'test' ], $result );
        $this->expectException( TypeException::class );
        OK::preg_split_list( '/\s+/', 'this is a test', -1, PREG_SPLIT_OFFSET_CAPTURE );
    }


    public function testPregSplitOffset() : void {
        $r = OK::preg_split_offset( '/\s+/', 'this is a test', -1, PREG_SPLIT_OFFSET_CAPTURE );
        self::assertSame(
            [ [ 'this', 0 ], [ 'is', 5 ], [ 'a', 8 ], [ 'test', 10 ] ],
            $r
        );

        $this->expectException( TypeException::class );
        OK::preg_split_offset( '/\s+/', 'this is a test' );
    }


    public function testRealPath() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::realpath( __FILE__ ) );
        $this->expectException( TypeException::class );
        OK::realpath( '/no/such/file' );
    }


    /** @noinspection SpellCheckingInspection */
    public function testScandir() : void {
        $r = OK::scandir( __DIR__ );
        self::assertContains( basename( __FILE__ ), $r );

        $this->expectException( TypeException::class );
        OK::scandir( '/no/such/dir' );
    }


    public function testSocketBind() : void {
        $socket = OK::socket_create( AF_INET, SOCK_STREAM, 0 );
        OK::socket_bind( $socket, '0.0.0.0' );
        OK::socket_getsockname( $socket, $address, $port );
        self::assertIsInt( $port );
        self::assertGreaterThan( 0, $port );
        socket_close( $socket );

        $socket = OK::socket_create( AF_UNIX, SOCK_STREAM, 0 );
        $this->expectException( UnexpectedFailureException::class );
        OK::socket_bind( $socket, '/no/such/path/socket.sock' );
    }


    public function testSocketCreate() : void {
        $socket = OK::socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
        /**
         * @noinspection PhpConditionAlreadyCheckedInspection
         * @noinspection UnnecessaryAssertionInspection
         */
        self::assertInstanceOf( \Socket::class, $socket );
        socket_close( $socket );

        $this->expectException( UnexpectedFailureException::class );
        OK::socket_create( AF_UNIX, SOCK_STREAM, SOL_TCP );
    }


    public function testSocketCreatePair() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        self::assertCount( 2, $sockets );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );

        $this->expectException( UnexpectedFailureException::class );
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, SOL_TCP, $sockets );
    }


    public function testSocketRead() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        socket_write( $sockets[ 0 ], 'test data' );
        self::assertSame( 'test data', OK::socket_read( $sockets[ 1 ], 1000 ) );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );
    }


    public function testSocketRecv() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        socket_write( $sockets[ 0 ], 'test data' );
        self::assertSame( 9, OK::socket_recv( $sockets[ 1 ], $st, 1000, 0 ) );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );
    }


    public function testSocketRecvFrom() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        socket_write( $sockets[ 0 ], 'test data' );
        self::assertSame( 9, OK::socket_recvfrom( $sockets[ 1 ], $st, 1000, 0, $from, $port ) );
        self::assertSame( 'test data', $st );
        self::assertSame( '', $from );
        self::assertNull( $port );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );
    }


    public function testSocketSend() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        self::assertSame( 9, OK::socket_send( $sockets[ 0 ], 'test data', 1000, 0 ) );
        $data = OK::socket_read( $sockets[ 1 ], 1000 );
        self::assertSame( 'test data', $data );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );
    }


    public function testSocketSendTo() : void {
        $socket1 = OK::socket_create( AF_INET, SOCK_DGRAM, 0 );
        $socket2 = OK::socket_create( AF_INET, SOCK_DGRAM, 0 );
        OK::socket_bind( $socket1, '127.0.0.1' );
        OK::socket_getsockname( $socket1, $address, $port );
        assert( is_string( $address ) );
        assert( is_int( $port ) );
        self::assertSame( 9, OK::socket_sendto( $socket2, 'test data', 1000, 0, $address, $port ) );
        $data = OK::socket_read( $socket1, 1000 );
        self::assertSame( 'test data', $data );
        socket_close( $socket1 );
        socket_close( $socket2 );
    }


    public function testSocketWrite() : void {
        OK::socket_create_pair( AF_UNIX, SOCK_STREAM, 0, $sockets );
        /** @phpstan-ignore function.alreadyNarrowedType */
        assert( is_array( $sockets ) );
        self::assertSame( 9, OK::socket_write( $sockets[ 0 ], 'test data', 9 ) );
        $data = OK::socket_read( $sockets[ 1 ], 1000 );
        self::assertSame( 'test data', $data );
        socket_close( $sockets[ 0 ] );
        socket_close( $sockets[ 1 ] );
    }


    public function testStrToTime() : void {
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsInt( OK::strtotime( 'now' ) );
        $this->expectException( TypeException::class );
        OK::strtotime( 'invalid date string' );
    }


    public function testStreamGetContents() : void {
        $fh = OK::fopen( __FILE__, 'r' );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsString( OK::stream_get_contents( $fh ) );
        fclose( $fh );
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
        $this->expectException( TypeException::class );
        $oldTemp = OK::ini_set( 'sys_temp_dir', '/no/such/path' );
        try {
            OK::tempnam( __DIR__, 'test' );
        } catch ( TypeException $e ) {
            OK::ini_set( 'sys_temp_dir', $oldTemp );
            throw $e;
        }
    }


    public function testUnpack() : void {
        $data = OK::pack( 'C*', 1, 2, 3, 4 );
        /** @phpstan-ignore staticMethod.alreadyNarrowedType */
        self::assertIsArray( OK::unpack( 'C*', $data ) );
        $this->expectException( TypeException::class );
        $old = set_error_handler( null );
        OK::unpack( 'NNN', 'AB' );
        set_error_handler( $old );
    }


}