<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Stringable;


final class Convert {


    /** @return list<mixed> */
    public static function list( mixed $i_value ) : array {
        if ( ! is_array( $i_value ) ) {
            $i_value = [ $i_value ];
        }
        return array_values( $i_value );
    }


    /**
     * @param list<int>|int $i_value
     * @return list<int>
     */
    public static function listOrInt( array|int $i_value ) : array {
        return is_array( $i_value ) ? array_values( $i_value ) : [ $i_value ];
    }


    /**
     * @param list<string>|string $i_value
     * @return list<string>
     */
    public static function listOrString( array|string $i_value ) : array {
        return is_array( $i_value ) ? array_values( $i_value ) : [ $i_value ];
    }


    /**
     * @param list<string|Stringable>|string|Stringable $i_value
     * @return list<string|Stringable>
     */
    public static function listOrStringy( array|string|Stringable $i_value ) : array {
        return is_array( $i_value ) ? array_values( $i_value ) : [ $i_value ];
    }


}
