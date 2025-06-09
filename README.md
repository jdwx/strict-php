This module is designed to make it easier to write PHP that works with strict type checks in static analysis. It also helps to balance the need to always check that functions didn't fail with the YAGNI of preemptively handling errors that never occur.

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

In this case, OK::preg_match() will still return 0 if there is no match, but will throw an exception if preg_match() fails. If that happens, you'll know that you need to insert real error handling code.

