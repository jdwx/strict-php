<?php


declare( strict_types = 1 );


namespace JDWX\Strict;


use JDWX\Strict\Exceptions\TypeException;
use Stringable;


final class TypeIs {


    /** @return mixed[] */
    public static function array( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'array', $i_value, $i_nstContext );
    }


    /** @return array<int|string, ?string> */
    public static function arrayNullableString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! is_null( $val ) ) {
                    throw new TypeException( '?string value', $val, $i_nstContext );
                }
            } );
            /** @phpstan-var array<string|null> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<?string>', $i_value, $i_nstContext );
    }


    /** @return array<int|string, string|Stringable|null> */
    public static function arrayNullableStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) && ! is_null( $val ) ) {
                    throw new TypeException( 'string|Stringable|null value', $val, $i_nstContext );
                }
            } );
            /** @phpstan-var array<string|Stringable|null> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<?string|Stringable>', $i_value, $i_nstContext );
    }


    /** @return array<int|string, mixed>|null */
    public static function arrayOrNull( mixed $i_value, ?string $i_nstContext = null ) : ?array {
        if ( is_array( $i_value ) || is_null( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'array or null', $i_value, $i_nstContext );
    }


    /** @return array<int|string, string> */
    public static function arrayString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) ) {
                    throw new TypeException( 'string value', $val, $i_nstContext );
                }
            } );
            /** @phpstan-var array<string> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<string>', $i_value, $i_nstContext );
    }


    /** @return array<int|string, array<int|string, string>|string> */
    public static function arrayStringOrArrayString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            foreach ( $i_value as $val ) {
                self::stringOrArrayString( $val, $i_nstContext );
            }
            /** @phpstan-var array<int|string, string|array<string>> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<string|array<string>>', $i_value, $i_nstContext );
    }


    /** @return array<int|string, string|list<string>> */
    public static function arrayStringOrListString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            foreach ( $i_value as $val ) {
                self::stringOrListString( $val, $i_nstContext );
            }
            /** @phpstan-var array<string|list<string>> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<string|list<string>>', $i_value, $i_nstContext );
    }


    /** @return array<int|string, string|Stringable> */
    public static function arrayStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) ) {
                    throw new TypeException( 'string|Stringable value', $val, $i_nstContext );
                }
            } );
            /** @phpstan-var array<string|Stringable> $i_value */
            return $i_value;
        }
        throw new TypeException( 'array<string|Stringable>', $i_value, $i_nstContext );
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


    /** @return iterable<int|string, mixed> */
    public static function iterable( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'iterable', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, ?string> */
    public static function iterableNullableString( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                if ( ! is_string( $val ) && ! is_null( $val ) ) {
                    throw new TypeException( '?string value', $val, $i_nstContext );
                }
                yield $key => $val;
            }
            return;
        }
        throw new TypeException( 'iterable<?string>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, string|Stringable|null> */
    public static function iterableNullableStringy( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) && ! is_null( $val ) ) {
                    throw new TypeException( 'string|Stringable|null value', $val, $i_nstContext );
                }
                yield $key => $val;
            }
            return;
        }
        throw new TypeException( 'iterable<?string|Stringable>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, string> */
    public static function iterableString( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                yield $key => self::string( $val );
            }
            return;
        }
        throw new TypeException( 'iterable<string>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, array<int|string, string>|string> */
    public static function iterableStringOrArrayString( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                yield $key => self::stringOrArrayString( $val, $i_nstContext );
            }
            return;
        }
        throw new TypeException( 'iterable<string|array<string>>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, string|list<string>> */
    public static function iterableStringOrListString( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                yield $key => self::stringOrListString( $val, $i_nstContext );
            }
            return;
        }
        throw new TypeException( 'iterable<string|list<string>>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, array<string, string>|string> */
    public static function iterableStringOrMapString( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                yield $key => self::stringOrMapString( $val, $i_nstContext );
            }
            return;
        }
        throw new TypeException( 'iterable<string|array<string>>', $i_value, $i_nstContext );
    }


    /** @return iterable<int|string, string|Stringable> */
    public static function iterableStringy( mixed $i_value, ?string $i_nstContext = null ) : iterable {
        if ( is_iterable( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) ) {
                    throw new TypeException( 'string|Stringable value', $val, $i_nstContext );
                }
                yield $key => $val;
            }
            return;
        }
        throw new TypeException( 'iterable<string|Stringable>', $i_value, $i_nstContext );
    }


    /** @return list<string|null> */
    public static function listNullableString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val, $key ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! is_null( $val ) ) {
                    throw new TypeException( '?string value', $val, $i_nstContext );
                }
                if ( ! is_int( $key ) ) {
                    throw new TypeException( 'int key', $key, $i_nstContext );
                }
            } );
            /** @phpstan-var list<string> $i_value */
            return $i_value;
        }
        throw new TypeException( 'list<?string>', $i_value, $i_nstContext );
    }


    /** @return list<string|Stringable> */
    public static function listNullableStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val, $key ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) && ! is_null( $val ) ) {
                    throw new TypeException( 'string|Stringable|null value', $val, $i_nstContext );
                }
                if ( ! is_int( $key ) ) {
                    throw new TypeException( 'int key', $key, $i_nstContext );
                }
            } );
            /** @phpstan-var list<string|Stringable> $i_value */
            return $i_value;
        }
        throw new TypeException( 'list<?string|Stringable>', $i_value, $i_nstContext );
    }


    /** @return list<string> */
    public static function listString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val, $key ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) ) {
                    throw new TypeException( 'string value', $val, $i_nstContext );
                }
                if ( ! is_int( $key ) ) {
                    throw new TypeException( 'int key', $key, $i_nstContext );
                }
            } );
            /** @phpstan-var list<string> $i_value */
            return $i_value;
        }
        throw new TypeException( 'list<string>', $i_value, $i_nstContext );
    }


    /** @return list<list<string>|string> */
    public static function listStringOrListString( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            foreach ( $i_value as $key => $val ) {
                self::int( $key, $i_nstContext );
                self::stringOrListString( $val, $i_nstContext );
            }
            /** @phpstan-var list<string|list<string>> $i_value */
            return $i_value;
        }
        throw new TypeException( 'list<string|list<string>>', $i_value, $i_nstContext );
    }


    /** @return list<string|Stringable> */
    public static function listStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        if ( is_array( $i_value ) ) {
            array_walk( $i_value, static function ( $val, $key ) use ( $i_nstContext ) : void {
                if ( ! is_string( $val ) && ! ( $val instanceof Stringable ) ) {
                    throw new TypeException( 'string|Stringable value', $val, $i_nstContext );
                }
                if ( ! is_int( $key ) ) {
                    throw new TypeException( 'int key', $key, $i_nstContext );
                }
            } );
            /** @phpstan-var list<string|Stringable> $i_value */
            return $i_value;
        }
        throw new TypeException( 'list<string|Stringable>', $i_value, $i_nstContext );
    }


    /** @return array<string, ?string> */
    public static function mapNullableString( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayNullableString( $i_value, $i_nstContext );
    }


    /** @return array<string, string|Stringable|null> */
    public static function mapNullableStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayNullableStringy( $i_value, $i_nstContext );
    }


    /** @return array<string, string> */
    public static function mapString( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayString( $i_value, $i_nstContext );
    }


    /** @return array<string, array<int|string, string>|string> */
    public static function mapStringOrArrayString( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayStringOrArrayString( $i_value, $i_nstContext );
    }


    /** @return array<string, list<string>|string> */
    public static function mapStringOrListString( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayStringOrListString( $i_value, $i_nstContext );
    }


    /** @return array<string, string|Stringable> */
    public static function mapStringy( mixed $i_value, ?string $i_nstContext = null ) : array {
        /** @phpstan-ignore return.type */
        return self::arrayStringy( $i_value, $i_nstContext );
    }


    public static function object( mixed $i_value, ?string $i_nstContext = null ) : object {
        if ( is_object( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'object', $i_value, $i_nstContext );
    }


    /**
     * @return resource
     * @suppress PhanTypeMismatchDeclaredReturnNullable
     */
    public static function resource( mixed $i_value, ?string $i_nstContext = null ) : mixed {
        if ( is_resource( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'resource', $i_value, $i_nstContext );
    }


    /** @noinspection PhpComposerExtensionStubsInspection */
    public static function socket( mixed $i_value, ?string $i_nstContext = null ) : \Socket {
        if ( $i_value instanceof \Socket ) {
            return $i_value;
        }
        throw new TypeException( 'socket', $i_value, $i_nstContext );
    }


    public static function string( mixed $i_value, ?string $i_nstContext = null ) : string {
        if ( is_string( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'string', $i_value, $i_nstContext );
    }


    /** @return array<int|string, string>|string */
    public static function stringOrArrayString( mixed $i_value, ?string $i_nstContext = null ) : array|string {
        if ( is_array( $i_value ) ) {
            return self::arrayString( $i_value, $i_nstContext );
        }
        return self::string( $i_value, $i_nstContext );
    }


    /**
     * @param array<int|string, mixed>|mixed $i_value
     * @return list<string>|string
     *
     * We're not going to try to cover every possible case here, but "string or list<string>"
     * covers a lot of common scenarios like HTTP and MIME headers.
     */
    public static function stringOrListString( mixed $i_value, ?string $i_nstContext = null ) : array|string {
        if ( is_array( $i_value ) ) {
            return self::listString( $i_value, $i_nstContext );
        }
        return self::string( $i_value, $i_nstContext );
    }


    /**
     * @param array<int|string, mixed>|mixed $i_value
     * @return array<string, string>|string
     */
    public static function stringOrMapString( mixed $i_value, ?string $i_nstContext = null ) : array|string {
        if ( is_array( $i_value ) ) {
            return self::mapString( $i_value, $i_nstContext );
        }
        return self::string( $i_value, $i_nstContext );
    }


    /**
     * @param mixed $i_value
     * @param string|null $i_nstContext
     * @return string|null
     */
    public static function stringOrNull( mixed $i_value, ?string $i_nstContext = null ) : ?string {
        if ( is_string( $i_value ) || is_null( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'string or null', $i_value, $i_nstContext );
    }


    public static function stringy( mixed $i_value, ?string $i_nstContext = null ) : string|Stringable {
        if ( is_string( $i_value ) || $i_value instanceof Stringable ) {
            return $i_value;
        }
        throw new TypeException( 'string or Stringable', $i_value, $i_nstContext );
    }


    public static function stringyOrNull( mixed $i_value, ?string $i_nstContext = null ) : string|Stringable|null {
        if ( is_string( $i_value ) || $i_value instanceof Stringable || is_null( $i_value ) ) {
            return $i_value;
        }
        throw new TypeException( 'string, Stringable or null', $i_value, $i_nstContext );
    }


    public static function true( mixed $i_value, ?string $i_nstContext = null ) : true {
        if ( $i_value === true ) {
            return true;
        }
        throw new TypeException( 'true', $i_value, $i_nstContext );
    }


}