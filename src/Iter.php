<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use Stringable;


final class Iter {


    /**
     * @param iterable<mixed> $i_it
     * @return iterable<mixed>
     */
    public static function list( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield $v;
        }
    }


    /**
     * @param iterable<float> $i_it
     * @return iterable<float>
     */
    public static function listFloat( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::float( $v );
        }
    }


    /**
     * @param iterable<int> $i_it
     * @return iterable<int>
     */
    public static function listInt( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::int( $v );
        }
    }


    /**
     * @param iterable<string> $i_it
     * @return iterable<string>
     */
    public static function listString( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::string( $v );
        }
    }


    /**
     * @param iterable<string|null> $i_it
     * @return iterable<string|null>
     */
    public static function listStringOrNull( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::stringOrNull( $v );
        }
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
     */
    public static function listStringyOrNull( iterable $i_it ) : iterable {
        foreach ( $i_it as $v ) {
            yield TypeIs::stringyOrNull( $v );
        }
    }


    /**
     * @param iterable<string, mixed> $i_it
     * @return \Generator<string, mixed>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function map( iterable $i_it ) : \Generator {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => $v;
        }
    }


    /**
     * @param iterable<string, float> $i_it
     * @return iterable<string, float>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapFloat( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::float( $v );
        }
    }


    /**
     * @param iterable<string, int> $i_it
     * @return iterable<string, int>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapInt( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::int( $v );
        }
    }


    /**
     * @param iterable<string, string> $i_it
     * @return iterable<string, string>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapString( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::string( $v );
        }
    }


    /**
     * @param iterable<string, string|null> $i_it
     * @return iterable<string, string|null>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapStringOrNull( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringOrNull( $v );
        }
    }


    /**
     * @param iterable<string, string|Stringable> $i_it
     * @return iterable<string, string|Stringable>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapStringy( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringy( $v );
        }
    }


    /**
     * @param iterable<string, string|Stringable|null> $i_it
     * @return iterable<string, string|Stringable|null>
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    public static function mapStringyOrNull( iterable $i_it ) : iterable {
        foreach ( $i_it as $k => $v ) {
            yield strval( $k ) => TypeIs::stringyOrNull( $v );
        }
    }


}
