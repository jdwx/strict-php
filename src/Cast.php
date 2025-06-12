<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Stringable;


final class Cast {


    /**
     * @param iterable<int|string, mixed> $i_value
     * @return list<mixed>
     */
    public static function list( iterable $i_value ) : array {
        return iterator_to_array( Iter::list( $i_value ), false );
    }


    /**
     * @param iterable<int|string, float> $i_value
     * @return list<float>
     */
    public static function listFloat( iterable $i_value ) : array {
        return iterator_to_array( Iter::listFloat( $i_value ), false );
    }


    /**
     * @param iterable<int|string, int> $i_value
     * @return list<int>
     */
    public static function listInt( iterable $i_value ) : array {
        return iterator_to_array( Iter::listInt( $i_value ), false );
    }


    /**
     * @param iterable<int|string, ?string> $i_value
     * @return list<?string>
     */
    public static function listNullableString( iterable $i_value ) : array {
        return iterator_to_array( Iter::listNullableString( $i_value ), false );
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_value
     * @return list<string|Stringable|null>
     */
    public static function listNullableStringy( iterable $i_value ) : array {
        return iterator_to_array( Iter::listNullableStringy( $i_value ), false );
    }


    /**
     * @param iterable<int|string, string> $i_value
     * @return list<string>
     */
    public static function listString( iterable $i_value ) : array {
        return iterator_to_array( Iter::listString( $i_value ), false );
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_value
     * @return list<list<string>|string>
     */
    public static function listStringOrListString( iterable $i_value ) : array {
        return iterator_to_array( Iter::listStringOrStringList( $i_value ), false );
    }


    /**
     * @param iterable<int|string, ?string> $i_value
     * @return list<?string>
     * @deprecated Use listNullableString() instead.
     * @codeCoverageIgnore
     */
    public static function listStringOrNull( iterable $i_value ) : array {
        return self::listNullableString( $i_value );
    }


    /**
     * @param iterable<int|string, string|Stringable> $i_value
     * @return list<string|Stringable>
     */
    public static function listStringy( iterable $i_value ) : array {
        return iterator_to_array( Iter::listStringy( $i_value ), false );
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_value
     * @return list<string|Stringable|null>
     * @deprecated Use listNullableStringy() instead.
     * @codeCoverageIgnore
     */
    public static function listStringyOrNull( iterable $i_value ) : array {
        return self::listNullableStringy( $i_value );
    }


    /**
     * @param iterable<int|string, mixed> $i_value
     * @return array<string, mixed>
     */
    public static function map( iterable $i_value ) : array {
        return iterator_to_array( Iter::map( $i_value ) );
    }


    /**
     * @param iterable<int|string, float> $i_value
     * @return array<string, float>
     */
    public static function mapFloat( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapFloat( $i_value ) );
    }


    /**
     * @param iterable<int|string, int> $i_value
     * @return array<string, int>
     */
    public static function mapInt( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapInt( $i_value ) );
    }


    /**
     * @param iterable<int|string, ?string> $i_value
     * @return array<string, ?string>
     */
    public static function mapNullableString( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapNullableString( $i_value ) );
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_value
     * @return array<string, string|Stringable|null>
     */
    public static function mapNullableStringy( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapNullableStringy( $i_value ) );
    }


    /**
     * @param iterable<int|string, string> $i_value
     * @return array<string, string>
     */
    public static function mapString( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapString( $i_value ) );
    }


    /**
     * @param iterable<int|string, string|list<string>> $i_value
     * @return array<string, string|list<string>>
     */
    public static function mapStringOrListString( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapStringOrListString( $i_value ) );
    }


    /**
     * @param iterable<int|string, ?string> $i_value
     * @return array<string, ?string>
     * @deprecated Use mapNullableString() instead.
     * @codeCoverageIgnore
     */
    public static function mapStringOrNull( iterable $i_value ) : array {
        return self::mapNullableString( $i_value );
    }


    /**
     * @param iterable<int|string, string|Stringable> $i_value
     * @return array<string, string|Stringable>
     */
    public static function mapStringy( iterable $i_value ) : array {
        return iterator_to_array( Iter::mapStringy( $i_value ) );
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_value
     * @return array<string, string|Stringable|null>
     * @deprecated Use mapNullableStringy() instead.
     * @codeCoverageIgnore
     */
    public static function mapStringyOrNull( iterable $i_value ) : array {
        return self::mapNullableStringy( $i_value );
    }


}
