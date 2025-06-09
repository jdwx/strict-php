<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Stringable;


final class TypeIs {


    public static function array( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'array', $i_value, $i_nstContext );
    }


    public static function bool( mixed $i_value, ?string $i_nstContext = null ) : bool {
        if ( is_bool( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'bool', $i_value, $i_nstContext );
    }


    public static function callable( mixed $i_value, ?string $i_nstContext = null ) : callable {
        if ( is_callable( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'callable', $i_value, $i_nstContext );
    }


    public static function float( mixed $i_value, ?string $i_nstContext = null ) : float {
        if ( is_float( $i_value ) || is_int( $i_value ) ) {
            return (float) $i_value;
        }
        throw new TypeException( 'float', $i_value, $i_nstContext );
    }


    public static function int( mixed $i_value, ?string $i_nstContext = null ) : int {
        if ( is_int( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'int', $i_value, $i_nstContext );
    }


    public static function object( mixed $i_value, ?string $i_nstContext = null ) : object {
        if ( is_object( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'object', $i_value, $i_nstContext );
    }


    public static function resource( mixed $i_value, ?string $i_nstContext = null ) : mixed {
        if ( is_resource( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'resource', $i_value, $i_nstContext );
    }


    public static function string( mixed $i_value, ?string $i_nstContext = null ) : string {
        if ( is_string( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'string', $i_value, $i_nstContext );
    }


    public static function stringy( mixed $i_value, ?string $i_nstContext = null ) : string|Stringable {
        if ( is_string( $i_value ) || $i_value instanceof Stringable ) {
            return $i_value;
        }
        throw new TypeException( 'string or Stringable', $i_value, $i_nstContext );
    }


    public static function true( mixed $i_value, ?string $i_nstContext = null ) : true {
        if ( $i_value === true ) {
            return true;
        }
        throw new TypeException( 'true', $i_value, $i_nstContext );
    }


}