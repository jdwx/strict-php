<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Stringable;


final class Iter {


    /**
     * @param iterable<int|string, string> $i_it
     * @return iterable<int|string, string>
     */
    public static function arrayString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield $k => TypeIs::string( $v );
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int|string, array<int|string, string>|string>
     */
    public static function arrayStringOrArrayString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            if ( is_array( $v ) ) {
                yield $k => iterator_to_array( self::arrayString( $v ) );
            } else {
                yield $k => TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int|string, list<string>|string>
     */
    public static function arrayStringOrListString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            if ( is_array( $v ) ) {
                yield $k => iterator_to_array( self::listString( $v ), false );
            } else {
                yield $k => TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int|string, array<string, string>|string>
     */
    public static function arrayStringOrMapString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            if ( is_array( $v ) ) {
                yield $k => iterator_to_array( self::mapString( $v ) );
            } else {
                yield $k => TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<mixed> $i_it
     * @return iterable<int, mixed>
     */
    public static function list( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield $v;
        }
    }


    /**
     * @param iterable<float> $i_it
     * @return iterable<int, float>
     */
    public static function listFloat( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::float( $v );
        }
    }


    /**
     * @param iterable<int> $i_it
     * @return iterable<int, int>
     */
    public static function listInt( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::int( $v );
        }
    }


    /**
     * @param iterable<string|null> $i_it
     * @return iterable<int, string|null>
     */
    public static function listNullableString( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::stringOrNull( $v );
        }
    }


    /**
     * @param iterable<string|Stringable|null> $i_it
     * @return iterable<string|Stringable|null>
     */
    public static function listNullableStringy( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::stringyOrNull( $v );
        }
    }


    /**
     * @param iterable<string> $i_it
     * @return iterable<int, string>
     */
    public static function listString( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::string( $v );
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int, array<int|string, string>|string>
     */
    public static function listStringOrArrayString( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            if ( is_array( $v ) ) {
                yield iterator_to_array( self::arrayString( $v ) );
            } else {
                yield TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int, list<string>|string>
     */
    public static function listStringOrListString( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            if ( is_array( $v ) ) {
                yield iterator_to_array( self::listString( $v ), false );
            } else {
                yield TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<string, array<string, string>|string>
     * @suppress PhanTypeMismatchReturn
     */
    public static function listStringOrMapString( iterable $i_it ) : iterable {
        /** @phpstan-ignore return.type */
        return self::listStringOrArrayString( $i_it );
    }


    /**
     * @param iterable<string|null> $i_it
     * @return iterable<int, string|null>
     * @deprecated Use listNullableString() instead.
     * @codeCoverageIgnore
     */
    public static function listStringOrNull( iterable $i_it ) : iterable {
        return self::listNullableString( $i_it );
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<int, list<string>|string>
     * @deprecated Use listStringOrListString() instead.
     * @codeCoverageIgnore
     */
    public static function listStringOrStringList( iterable $i_it ) : iterable {
        yield from self::listStringOrListString( $i_it );
    }


    /**
     * @param iterable<string|Stringable> $i_it
     * @return iterable<string|Stringable>
     */
    public static function listStringy( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::stringy( $v );
        }
    }


    /**
     * @param iterable<string|Stringable|null> $i_it
     * @return iterable<string|Stringable|null>
     * @deprecated Use listNullableStringy() instead.
     * @codeCoverageIgnore
     */
    public static function listStringyOrNull( iterable $i_it ) : iterable {
        return self::listNullableStringy( $i_it );
    }


    /**
     * @param iterable<int|string, mixed> $i_it
     * @return \Generator<string, mixed>
     */
    public static function map( iterable $i_it ) : \Generator {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => $v;
        }
    }


    /**
     * @param iterable<int|string, float> $i_it
     * @return iterable<string, float>
     */
    public static function mapFloat( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::float( $v );
        }
    }


    /**
     * @param iterable<int|string, int> $i_it
     * @return iterable<string, int>
     */
    public static function mapInt( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::int( $v );
        }
    }


    /**
     * @param iterable<int|string, string|null> $i_it
     * @return iterable<string, string|null>
     */
    public static function mapNullableString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringOrNull( $v );
        }
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_it
     * @return iterable<string, string|Stringable|null>
     */
    public static function mapNullableStringy( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringyOrNull( $v );
        }
    }


    /**
     * @param iterable<int|string, string> $i_it
     * @return iterable<string, string>
     */
    public static function mapString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::string( $v );
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<string, array<int|string, string>|string>
     */
    public static function mapStringOrArrayString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            if ( is_array( $v ) ) {
                yield strval( $k ) => iterator_to_array( self::arrayString( $v ) );
            } else {
                yield strval( $k ) => TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, list<string>|string> $i_it
     * @return iterable<string, list<string>|string>
     */
    public static function mapStringOrListString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringOrListString( $v );
        }
    }


    /**
     * @param iterable<int|string, array<int|string, string>|string> $i_it
     * @return iterable<string, array<string, string>|string>
     */
    public static function mapStringOrMapString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            if ( is_array( $v ) ) {
                /** @phpstan-ignore generator.valueType */
                yield strval( $k ) => iterator_to_array( self::arrayString( $v ) );
            } else {
                yield strval( $k ) => TypeIs::string( $v );
            }
        }
    }


    /**
     * @param iterable<int|string, string|null> $i_it
     * @return iterable<string, string|null>
     * @deprecated Use mapNullableString() instead.
     * @codeCoverageIgnore
     */
    public static function mapStringOrNull( iterable $i_it ) : iterable {
        return self::mapNullableString( $i_it );
    }


    /**
     * @param iterable<int|string, string|Stringable> $i_it
     * @return iterable<string, string|Stringable>
     */
    public static function mapStringy( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringy( $v );
        }
    }


    /**
     * @param iterable<int|string, string|Stringable|null> $i_it
     * @return iterable<string, string|Stringable|null>
     * @deprecated Use mapNullableStringy() instead.
     * @codeCoverageIgnore
     */
    public static function mapStringyOrNull( iterable $i_it ) : iterable {
        return self::mapNullableStringy( $i_it );
    }


}
