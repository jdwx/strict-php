<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Throwable;


class TypeException extends StrictException {


    public function __construct( string $stExpected, mixed $value, ?string $nstContext,
                                 int    $code = 0, ?Throwable $previous = null ) {
        $stType = is_object( $value ) ? get_class( $value ) : gettype( $value );
        if ( is_array( $value ) ) {
            $stValue = 'array(' . count( $value ) . ')';
        } elseif ( is_object( $value ) ) {
            $stValue = gettype( $value );
        } elseif ( is_resource( $value ) ) {
            $stValue = '(' . get_resource_type( $value ) . ')';
        } else {
            $stValue = strval( $value );
        }
        $nstContext = $nstContext ?? 'type check';
        parent::__construct( "For {$nstContext}: expected {$stExpected} got {$stType} ({$stValue})",
            $code, $previous );
    }


}