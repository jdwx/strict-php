This module is designed to make it easier to write PHP that works with strict type checks in static analysis. It allows you to make type exceptions explicit without writing a ton of extra code. It also helps balance always check that functions didn't fail with the YAGNI of preemptively handling errors that may never occur. 

This is particularly helpful for quick and dirty code or prototyping.

## Return Value Checking

The OK class provides static methods for PHP functions that may fail. The static method calls the underlying PHP function and throws an exception if it fails.

For example, this code is incredibly common:

```php

if ( ! preg_match( '/test/', $string ) ) {
    echo "It didn't match!";
} else {
    echo "It matched!";
}
```

But preg_match() returns 0 if there is no match and false if there is an error.

With this module, you can write:

```php
if ( ! OK::preg_match( '/test/', $string ) ) {
    echo "It didn't match!";
} else {
    echo "It matched!";
}
```

In this case, OK::preg_match() will still return 0 if there is no match but will throw an exception if preg_match() fails. If that happens, you'll know that you need to insert real error handling code.

It can also reduce boilerplate code. For example, this:

```php
$contents = @file_get_contents( '/some/file' );
if ( ! is_string( $contents ) ) {
    throw new RuntimeException( 'file read failed!' );
}
```

can be reduced to:

```php
$contents = OK::file_get_contents( '/some/file' );
```

## Type Checking

The TypeIs class provides static methods for ensuring that a value is a given type. This is mostly for the benefit of static analysis, but can help detect unexpected types earlier than function call boundaries (assuming strict_types is enabled).

There are also some limitations to static analysis. For example, static analysis should raise a warning here at higher strictness levels:

```php
i_require_a_string( $string_or_null );
```

The way this is typically handled in our code is:

```php
assert( is_string( $string_or_null ) );
i_require_a_string( $string_or_null );
```

This is fast and usually works fine. But there are exceptions. For example, Phan (currently) does not allow narrowing the type of an instance property. So this will still generate a warning:

```php
assert( is_string( $this->string_or_null ) );
i_require_a_string( $this->string_or_null );
```

Typically, you have to introduce a locally scoped temporary variable to get around it:

```php
$string = $this->string_or_null;
assert( is_string( $string) );
i_require_a_string( $string );
```

The TypeIs class can help:

```php
i_require_a_string( TypeIs::string( $this->string_or_null ) );
```

This resolves the static analysis warning from Phan. And it's safe, because if your expectation that `$this->string_or_null` is already a string doesn't hold, an exception will be thrown.

Note that this is *very* different from `strval( $this->string_or_null )` because it is asserting that the value is already a string, not silently converting nulls to an empty string.

This is low overhead but not zero overhead. So it isn't ideal if you wind up using that property 30 times. In that case, it's still better to create the local variable:

```php
$string = TypeIs::string( $string_or_null );
i_require_a_string( $string );
i_also_require_a_string( $string );
i_too_require_a_string( $string );
```

## Iterators

In PHP, arrays serve as both maps and lists. (We distinguish "maps" as arrays with meaningful string keys and "lists" as arrays with ordinal integer keys.)

One of PHP's lingering "features" from its early years is that numbers stored as strings are converted to numbers when used as array keys. E.g. `$x[ "1" ] = 'one'` and `$x[ 1 ] = 'one'` are equivalent. This causes problems when strict_types is used:

```php

declare( strict_types = 1 );

/** @param array<string, string> */
function do_a_thing( array $r ) : void {
    foreach ( $r as $k => $v ) {
        i_require_a_string( $k );
    }
}

do_a_thing( [ 'a' => 'Ayyyyy!', '1' => 'one' ] );
```

This code will typically *pass* static analysis and then fail with a TypeError when run. That's not great! The Iter class is designed to handle these situations:

```php
declare( strict_types = 1 );

/** @param array<string, string> */
function do_a_thing( array $r ) : void {
    foreach ( Iter::mapString( $r ) as $k => $v ) {
        i_require_a_string( $k );
    }
}

do_a_thing( [ 'a' => 'Ayyyyy!', '1' => 'one' ] );
```

This avoids the need to remember to have every reference to `$k` use `strval( $k )` or to do `$k = strval( $k )` at the top of the loop. As a bonus, it also ensures that the value is really a string. (If that's undesirable, the Iter::map() and Iter::list() static methods don't perform any type checking of the values returned.)

## Conversion

The Convert class provides some simple helper static functions for common cases of parameter handling. For example, it's often desirable to accept a single string in lieu of a list so people don't have to write `do_things( [ 'one_thing' ] )`:

```php

/** @param list<string>|string $targets */
function do_things( array|string $targets ) : void {
    if ( ! is_array( $targets ) ) {
        $targets = [ $targets ];
    }
    // ...
    foreach ( $targets as $target ) {
        do_a_thing( $target );
    }
}
```

With the Convert class:

```php
/** @param list<string>|string $targets */
function do_things( array|string $targets ) : void {
    foreach ( Convert::listOrString( $targets ) as $target ) {
        do_a_thing( $target );
    }
}
```