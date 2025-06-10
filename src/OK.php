<?php
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


    public static function fclose( mixed $handle ) : bool {
        return TypeIs::true( @fclose( $handle ), 'fclose return value' );
    }


    /** @suppress PhanTypeMismatchArgumentNullableInternal */
    public static function fgets( mixed $stream, ?int $length = null ) : string {
        return TypeIs::string( @fgets( $stream, $length ), 'fgets return value' );
    }


    public static function file_get_contents( string $filename, bool $use_include_path = false,
                                              mixed  $context = null ) : string {
        return TypeIs::string( @file_get_contents( $filename, $use_include_path, $context ),
            'file_get_contents return value' );
    }


    public static function file_put_contents( string $filename, mixed $data, int $flags = 0,
                                              mixed  $context = null ) : int {
        return TypeIs::int( @file_put_contents( $filename, $data, $flags, $context ),
            'file_put_contents return value' );
    }


    public static function fopen( string $filename, string $mode, bool $use_include_path = false,
                                  mixed  $context = null ) : mixed {
        return TypeIs::resource( @fopen( $filename, $mode, $use_include_path, $context ),
            'fopen return value' );
    }


    public static function fread( mixed $handle, int $length ) : string {
        return TypeIs::string( @fread( $handle, $length ), 'fread return value' );
    }


    /** @suppress PhanTypeMismatchArgumentNullableInternal */
    public static function fwrite( mixed $handle, string $string, ?int $length = null ) : int {
        return TypeIs::int( @fwrite( $handle, $string, $length ) );
    }


    public static function json_decode( string $json, bool $assoc = false, int $depth = 512,
                                        int    $options = 0 ) : mixed {
        $x = json_decode( $json, $assoc, $depth, $options );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            return $x;
        }
        throw new UnexpectedFailureException( 'json_decode', json_last_error_msg(),
            0, null );
    }


    /**
     * @param list<list<string|int>>|null &$matches
     * @param-out list<list<string|int>> $matches
     */
    public static function preg_match( string $pattern, string $subject, ?array &$matches = null,
                                       int    $flags = 0, int $offset = 0 ) : int {
        /**
         * @phpstan-ignore argument.type, paramOut.type
         */
        $result = @preg_match( $pattern, $subject, $matches, $flags, $offset );
        if ( is_int( $result ) ) {
            return $result;
        }
        throw new UnexpectedFailureException( 'preg_match', preg_last_error_msg(),
            0, null );
    }


    /** @suppress PhanTypeMismatchArgumentNullableInternal */
    public static function strtotime( string $datetime, ?int $baseTimestamp = null ) : int {
        return TypeIs::int( strtotime( $datetime, $baseTimestamp ), 'strtotime return value' );
    }


}