<?php /** @noinspection PhpComposerExtensionStubsInspection */


/**
 * @noinspection PhpClassNamingConventionInspection
 * @noinspection PhpMethodNamingConventionInspection
 * @noinspection PhpUsageOfSilenceOperatorInspection
 */


declare( strict_types = 1 );


namespace JDWX\Strict;


use JDWX\Strict\Exceptions\UnexpectedFailureException;
use PHPUnit\Framework\Attributes\CoversClass;


#[CoversClass( OK::class )]
final class OK {


    /**
     * @param resource $handle
     * @suppress PhanTypeMismatchDeclaredParamNullable
     */
    public static function fclose( mixed $handle ) : bool {
        return TypeIs::true( @fclose( $handle ), 'fclose return value' );
    }


    /**
     * @param resource $stream
     * @suppress PhanTypeMismatchDeclaredParamNullable
     * @suppress PhanTypeMismatchArgumentNullableInternal
     */
    public static function fgets( mixed $stream, ?int $length = null ) : string {
        assert( $length === null || $length >= 0, 'Length must be null or nonnegative' );
        return TypeIs::string( @fgets( $stream, $length ), 'fgets return value' );
    }


    /**
     * @param resource|null $context
     */
    public static function file_get_contents( string $filename, bool $use_include_path = false,
                                              mixed  $context = null ) : string {
        return TypeIs::string( @file_get_contents( $filename, $use_include_path, $context ),
            'file_get_contents return value' );
    }


    /**
     * @suppress PhanPossiblyNullTypeArgumentInternal
     * @param resource|null $context
     */
    public static function file_put_contents( string $filename, mixed $data, int $flags = 0,
                                              mixed  $context = null ) : int {
        return TypeIs::int( @file_put_contents( $filename, $data, $flags, $context ),
            'file_put_contents return value' );
    }


    /**
     * @param resource|null $context
     * @return resource
     * @suppress PhanPossiblyNullTypeArgumentInternal
     * @suppress PhanTypeMismatchDeclaredReturnNullable
     */
    public static function fopen( string $filename, string $mode, bool $use_include_path = false,
                                  mixed  $context = null ) : mixed {
        return TypeIs::resource( @fopen( $filename, $mode, $use_include_path, $context ),
            'fopen return value' );
    }


    /**
     * @param resource $handle
     * @suppress PhanTypeMismatchDeclaredParamNullable
     */
    public static function fread( mixed $handle, int $length ) : string {
        assert( $length > 0, 'Length must be greater than 0' );
        return TypeIs::string( @fread( $handle, $length ), 'fread return value' );
    }


    /**
     * @param resource $handle
     * @suppress PhanTypeMismatchArgumentNullableInternal
     * @suppress PhanTypeMismatchDeclaredParamNullable
     */
    public static function fwrite( mixed $handle, string $string, ?int $length = null ) : int {
        assert( $length === null || $length >= 0, 'Length must be null or nonnegative' );
        return TypeIs::int( @fwrite( $handle, $string, $length ) );
    }


    public static function http_response_code( int $code = 0 ) : int {
        return TypeIs::int( http_response_code( $code ), 'http_response_code return value' );
    }


    public static function ini_get( string $option ) : string {
        return TypeIs::string( ini_get( $option ), 'ini_get return value' );
    }


    public static function ini_set( string $option, string|int|float|bool|null $value ) : string {
        return TypeIs::string( ini_set( $option, $value ), 'ini_set return value' );
    }


    public static function json_decode( string $json, bool $assoc = false, int $depth = 512,
                                        int    $options = 0 ) : mixed {
        assert( $depth > 0, 'Depth must be greater than 0' );
        $x = json_decode( $json, $assoc, $depth, $options );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            return $x;
        }
        throw new UnexpectedFailureException( 'json_decode', json_last_error_msg(),
            0, null );
    }


    /**
     * @param array<int|string, string>|string $string
     * @return array<int|string, string>|string
     * @suppress PhanPartialTypeMismatchArgumentInternal
     */
    public static function mb_convert_encoding( array|string $string, string $to_encoding,
                                                ?string      $from_encoding = null ) : array|string {
        return TypeIs::stringOrArrayString( mb_convert_encoding( $string, $to_encoding, $from_encoding ) );
    }


    public static function mb_convert_encoding_string( string  $string, string $to_encoding,
                                                       ?string $from_encoding = null ) : string {
        return TypeIs::string( mb_convert_encoding( $string, $to_encoding, $from_encoding ) );
    }


    public static function ob_clean() : true {
        return TypeIs::true( ob_clean(), 'ob_clean return value' );
    }


    public static function ob_end_clean() : true {
        return TypeIs::true( ob_end_clean(), 'ob_end_clean return value' );
    }


    public static function ob_end_flush() : true {
        return TypeIs::true( ob_end_flush(), 'ob_end_flush return value' );
    }


    public static function ob_flush() : true {
        return TypeIs::true( ob_flush(), 'ob_flush return value' );
    }


    public static function ob_get_clean() : string {
        return TypeIs::string( ob_get_clean(), 'ob_get_clean return value' );
    }


    public static function ob_get_contents() : string {
        return TypeIs::string( ob_get_contents(), 'ob_get_contents return value' );
    }


    public static function ob_get_flush() : string {
        return TypeIs::string( ob_get_flush(), 'ob_get_flush return value' );
    }


    public static function ob_get_length() : int {
        return TypeIs::int( ob_get_length(), 'ob_get_length return value' );
    }


    public static function ob_start() : true {
        return TypeIs::true( ob_start(), 'ob_start return value' );
    }


    public static function pack( string $format, mixed ...$data ) : string {
        return TypeIs::string( pack( $format, ...$data ) );
    }


    /**
     * @param list<list<string|int>>|null &$matches
     * @param-out list<list<string|int>> $matches
     */
    public static function preg_match( string $pattern, string $subject, ?array &$matches = null,
                                       int    $flags = 0, int $offset = 0 ) : int {
        /** @phpstan-ignore argument.type, paramOut.type */
        $result = @preg_match( $pattern, $subject, $matches, $flags, $offset );
        if ( is_int( $result ) ) {
            return $result;
        }
        throw new UnexpectedFailureException( 'preg_match', preg_last_error_msg(),
            0, null );
    }


    /**
     * @param string|array<int, string> $pattern
     * @param string|array<int, string> $replacement
     * @param string|array<int|string, string> $subject
     * @param int $limit
     * @param int|null $count
     * @param-out int $count
     * @return string|array<int|string, string>
     */
    public static function preg_replace( string|array $pattern, string|array $replacement, string|array $subject,
                                         int          $limit = -1,
                                         ?int         &$count = null
    ) : string|array {
        $result = @preg_replace( $pattern, $replacement, $subject, $limit, $count );
        if ( is_string( $result ) || is_array( $result ) ) {
            return $result;
        }
        throw new UnexpectedFailureException( 'preg_replace', preg_last_error_msg(),
            0, null );
    }


    /**
     * @param array<int|string, string>|string $pattern
     * @param callable $callback
     * @param array<int|string, string>|string $subject
     * @param int $limit
     * @param ?int $count
     * @param-out int $count
     * @param int $flags
     * @return array<int|string, string>|string
     */
    public static function preg_replace_callback(
        string|array $pattern,
        callable     $callback,
        string|array $subject,
        int          $limit = -1,
        ?int         &$count = null,
        int          $flags = 0
    ) : string|array {
        $x = @preg_replace_callback( $pattern, $callback, $subject, $limit, $count, $flags );
        if ( is_array( $x ) || is_string( $x ) ) {
            return $x;
        }
        throw new UnexpectedFailureException( 'preg_replace_callback', preg_last_error_msg(),
            0, null );
    }


    /**
     * @param string $pattern
     * @param callable $callback
     * @param string $subject
     * @param int $limit
     * @param ?int $count
     * @param-out int $count
     * @param int $flags
     * @return string
     */
    public static function preg_replace_callback_string(
        string   $pattern,
        callable $callback,
        string   $subject,
        int      $limit = -1,
        ?int     &$count = null,
        int      $flags = 0
    ) : string {
        $x = @preg_replace_callback( $pattern, $callback, $subject, $limit, $count, $flags );
        if ( is_string( $x ) ) {
            return $x;
        }
        throw new UnexpectedFailureException( 'preg_replace_callback_string', preg_last_error_msg(),
            0, null );
    }


    /**
     * @param string $pattern
     * @param string $replacement
     * @param string $subject
     * @param int $limit
     * @param int|null $count
     * @param-out int $count
     * @return string
     */
    public static function preg_replace_string( string $pattern, string $replacement, string $subject,
                                                int    $limit = -1, ?int &$count = null ) : string {
        return TypeIs::string( self::preg_replace( $pattern, $replacement, $subject, $limit, $count ) );
    }


    /** @return list<array<int|string, int|string>|string> */
    public static function preg_split( string $pattern, string $subject, int $limit = -1, int $flags = 0 ) : array {
        $result = @preg_split( $pattern, $subject, $limit, $flags );
        if ( is_array( $result ) ) {
            return $result;
        }
        throw new UnexpectedFailureException( 'preg_split', preg_last_error_msg(),
            0, null );
    }


    /** @return list<string> */
    public static function preg_split_list( string $pattern, string $subject, int $limit = -1,
                                            int    $flags = 0 ) : array {
        return TypeIs::listString( self::preg_split( $pattern, $subject, $limit, $flags ) );
    }


    /**
     * @return list<array<int|string, int|string>>
     * @suppress PhanPartialTypeMismatchReturn
     */
    public static function preg_split_offset( string $pattern, string $subject, int $limit = -1,
                                              int    $flags = 0 ) : array {
        $r = self::preg_split( $pattern, $subject, $limit, $flags );
        foreach ( $r as $v ) {
            TypeIs::array( $v, 'preg_split_offset result' );
        }
        /** @phpstan-var list<array<int|string, int|string>> */
        return $r;
    }


    public static function realpath( string $path ) : string {
        return TypeIs::string( realpath( $path ), 'realpath return value' );
    }


    public static function socket_bind( \Socket $socket, string $address, int $port = 0 ) : void {
        $result = @socket_bind( $socket, $address, $port );
        if ( true === $result ) {
            return;
        }
        throw new UnexpectedFailureException( 'socket_bind', socket_strerror( socket_last_error() ),
            0, null );
    }


    public static function socket_create( int $domain, int $type, int $protocol ) : \Socket {
        $result = @socket_create( $domain, $type, $protocol );
        if ( $result instanceof \Socket ) {
            return $result;
        }
        throw new UnexpectedFailureException( 'socket_create', socket_strerror( socket_last_error() ),
            0, null );
    }


    /**
     * @param list<\Socket>|null $pair
     * @param-out list<\Socket> $pair
     */
    public static function socket_create_pair( int $domain, int $type, int $protocol, ?array &$pair ) : void {
        $result = @socket_create_pair( $domain, $type, $protocol, $pair );
        if ( true === $result ) {
            return;
        }
        throw new UnexpectedFailureException( 'socket_create_pair', socket_strerror( socket_last_error() ),
            0, null );
    }


    public static function socket_getsockname( \Socket $socket, ?string &$address, ?int &$port = null ) : void {
        $result = @socket_getsockname( $socket, $address, $port );
        if ( true === $result ) {
            return;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_getsockname', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    public static function socket_read( \Socket $socket, int $length, int $type = PHP_BINARY_READ ) : string {
        $result = @socket_read( $socket, $length, $type );
        if ( is_string( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_read', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    /**
     * @param \Socket $socket
     * @param ?string $data
     * @param-out string $data
     * @param int $len
     * @param int $flags
     * @return int
     */
    public static function socket_recv( \Socket $socket, ?string &$data, int $len, int $flags ) : int {
        $result = @socket_recv( $socket, $data, $len, $flags );
        if ( is_int( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_recv', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    /**
     * @param \Socket $socket
     * @param ?string $data
     * @param-out string $data
     * @param int $len
     * @param int $flags
     * @param string|null $address
     * @param-out string|null $address
     * @param int|null $port
     * @param-out int|null $port
     * @return int
     */
    public static function socket_recvfrom( \Socket $socket, ?string &$data, int $len, int $flags,
                                            ?string &$address, ?int &$port = null ) : int {
        $result = @socket_recvfrom( $socket, $data, $len, $flags, $address, $port );
        if ( is_int( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_recvfrom', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    public static function socket_send( \Socket $socket, string $data, int $len, int $flags ) : int {
        $result = @socket_send( $socket, $data, $len, $flags );
        if ( is_int( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_send', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    /** @suppress PhanTypeMismatchArgumentNullableInternal */
    public static function socket_sendto( \Socket $socket, string $data, int $len, int $flags,
                                          string  $address, ?int $port = null ) : int {
        $result = @socket_sendto( $socket, $data, $len, $flags, $address, $port );
        if ( is_int( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_sendto', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    public static function socket_write( \Socket $socket, string $data, int $len ) : int {
        $result = @socket_write( $socket, $data, $len );
        if ( is_int( $result ) ) {
            return $result;
        }
        // @codeCoverageIgnoreStart
        throw new UnexpectedFailureException( 'socket_write', socket_strerror( socket_last_error() ),
            0, null );
        // @codeCoverageIgnoreEnd
    }


    /** @suppress PhanTypeMismatchArgumentNullableInternal */
    public static function strtotime( string $datetime, ?int $baseTimestamp = null ) : int {
        return TypeIs::int( strtotime( $datetime, $baseTimestamp ), 'strtotime return value' );
    }


    public static function tempnam( string $directory, string $prefix ) : string {
        return TypeIs::string( tempnam( $directory, $prefix ) );
    }


    /** @return array<int|string, mixed> */
    public static function unpack( string $format, string $data ) : array {
        return TypeIs::array( unpack( $format, $data ), 'unpack return value' );
    }


}