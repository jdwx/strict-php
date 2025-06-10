<?php


declare( strict_types = 1 );


namespace JDWX\Strict\Exceptions;


use Throwable;


class TypeException extends StrictException {


    public function __construct( string $stExpected, mixed $value, ?string $nstContext = null,
                                 int    $code = 0, ?Throwable $previous = null ) {
        $stType = is_object( $value ) ? get_class( $value ) : gettype( $value );
        if ( is_array( $value ) ) {
            $stValue = 'array[' . count( $value ) . ']';
        } elseif ( is_object( $value ) ) {
            $stValue = gettype( $value );
        } elseif ( is_resource( $value ) ) {
            $stValue = get_resource_type( $value );
        } elseif ( is_string( $value ) ) {
            if ( strlen( $value ) > 10 ) {
                $stValue = '"' . substr( $value, 0, 7 ) . '..."';
            } else {
                $stValue = '"' . $value . '"';
            }
        } elseif ( is_null( $value ) ) {
            $stValue = 'null';
        } elseif ( true === $value ) {
            $stValue = 'true';
        } elseif ( false === $value ) {
            $stValue = 'false';
        } else {
            $stValue = strval( $value );
        }
        $nstContext = $nstContext ?? 'type check';
        parent::__construct( "For {$nstContext}: expected {$stExpected} got {$stType} ({$stValue})",
            $code, $previous );
    }


}