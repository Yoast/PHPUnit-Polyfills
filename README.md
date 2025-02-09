PHPUnit Polyfills
=====================================================

[![Version](https://img.shields.io/packagist/v/yoast/phpunit-polyfills?label=stable)][Packagist]
[![CS Build Status](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/cs.yml/badge.svg)](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/cs.yml)
[![Lint Build Status](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/lint.yml/badge.svg)](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/lint.yml)
[![Test Build Status](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/test.yml/badge.svg)](https://github.com/Yoast/PHPUnit-Polyfills/actions/workflows/test.yml)
[![Coverage Status](https://coveralls.io/repos/github/Yoast/PHPUnit-Polyfills/badge.svg?branch=3.x)](https://coveralls.io/github/Yoast/PHPUnit-Polyfills?branch=3.x)

[![Minimum PHP Version](https://img.shields.io/packagist/dependency-v/yoast/phpunit-polyfills/php.svg)][Packagist]
[![License: BSD3](https://img.shields.io/github/license/Yoast/PHPUnit-Polyfills)](https://github.com/Yoast/PHPUnit-Polyfills/blob/main/LICENSE)

[Packagist]: https://packagist.org/packages/yoast/phpunit-polyfills

Set of polyfills for changed PHPUnit functionality to allow for creating PHPUnit cross-version compatible tests.

* [Requirements](#requirements)
* [Installation](#installation)
    - [Autoloading](#autoloading)
* [Why use the PHPUnit Polyfills?](#why-use-the-phpunit-polyfills)
    - [PHPUnit support](#phpunit-support)
* [Using this library](#using-this-library)
    - [Supported ways of calling the assertions](#supported-ways-of-calling-the-assertions)
    - [Use with PHPUnit < 7.5.0](#use-with-phpunit--750)
* [Features](#features)
    - [Polyfill traits](#polyfill-traits)
    - [TestCases](#testcases)
    - [TestListener](#testlistener)
* [Frequently Asked Questions](#frequently-asked-questions)
* [Contributing](#contributing)
* [License](#license)


Requirements
------------

* PHP 7.0 or higher.
* [PHPUnit] 6.4 - 9.x and 11.x (automatically required via Composer).

[PHPUnit]: https://packagist.org/packages/phpunit/phpunit


Installation
------------

To install this package, run:
```bash
composer require --dev yoast/phpunit-polyfills:"^3.0"
```

To update this package, run:
```bash
composer update --dev yoast/phpunit-polyfills --with-dependencies
```

### Autoloading

Make sure to:
* Either use the Composer `vendor/autoload.php` file _as_ your test bootstrap file;
* Or require the `vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php` file _in_ your test bootstrap.


Why use the PHPUnit Polyfills?
------------------------------

This library is set up to allow for creating PHPUnit cross-version compatible tests by offering a number of polyfills for functionality which was introduced, split up or renamed in PHPUnit.

### Write your tests for PHPUnit 11.x and run them on PHPUnit 6.4 - 11.x

The polyfills have been setup to allow tests to be _forward_-compatible. What that means is, that your tests can use the assertions supported by the _latest_ PHPUnit version, even when running on older PHPUnit versions.

This puts the burden of upgrading to use the syntax of newer PHPUnit versions at the point when you want to _start_ running your tests on a newer version.
By doing so, dropping support for an older PHPUnit version becomes as straight-forward as removing it from the version constraint in your `composer.json` file.

### PHPUnit support

* Releases in the `1.x` series of the PHPUnit Polyfills support PHPUnit 4.8 - 9.x.
* Releases in the `2.x` series of the PHPUnit Polyfills support PHPUnit 5.7 - 10.x.
* Releases in the `3.x` series of the PHPUnit Polyfills support PHPUnit 6.4 - 11.x (but don't support running tests on PHPUnit 10).
* Releases in the `4.x` series of the PHPUnit Polyfills support PHPUnit 7.5 - 12.x (but don't support running tests on PHPUnit 10).

Please keep in mind that the PHPUnit Polyfills provide _forward_-compatibility.
This means that features which PHPUnit no longer supports in PHPUnit 10.x, like expecting PHP deprecation notices or warnings, will not be supported in the PHPUnit Polyfills 2.x series and features not supported in PHPUnit 11.x, will not be supported in the PHPUnit Polyfills 3.x series etc.

Please refer to the [PHPUnit 10 release notification]/[PHPUnit 10 changelog], [PHPUnit 11 release notification]/[PHPUnit 11 changelog] and/or the [PHPUnit 12 release notification]/[PHPUnit 12 changelog] to inform your decision on whether or not to upgrade (yet).

[PHPUnit 10 release notification]: https://phpunit.de/announcements/phpunit-10.html
[PHPUnit 10 changelog]:            https://github.com/sebastianbergmann/phpunit/blob/10.0.19/ChangeLog-10.0.md
[PHPUnit 11 release notification]: https://phpunit.de/announcements/phpunit-11.html
[PHPUnit 11 changelog]:            https://github.com/sebastianbergmann/phpunit/blob/11.0.10/ChangeLog-11.0.md
[PHPUnit 12 release notification]: https://phpunit.de/announcements/phpunit-12.html
[PHPUnit 12 changelog]:            https://github.com/sebastianbergmann/phpunit/blob/12.0.2/ChangeLog-12.0.md


Using this library
------------------

Each of the polyfills and helpers has been setup as a trait and can be imported and `use`d in any test file which extends the PHPUnit native `TestCase` class.

If the polyfill is not needed for the particular PHPUnit version on which the tests are being run, the autoloader
will automatically load an empty trait with that same name, so you can safely use these traits in tests which
need to be PHPUnit cross-version compatible.

```php
<?php

namespace Vendor\YourPackage\Tests;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

class FooTest extends TestCase
{
    use AssertIsType;

    public function testSomething()
    {
        $this->assertIsBool( $maybeBool );
        self::assertIsNotIterable( $maybeIterable );
    }
}
```

Alternatively, you can use one of the [`TestCase` classes](#testcases) provided by this library instead of using the PHPUnit native `TestCase` class.

In that case, all polyfills and helpers will be available whenever needed.

```php
<?php

namespace Vendor\YourPackage\Tests;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class FooTest extends TestCase
{
    public function testSomething()
    {
        $this->assertIsBool( $maybeBool );
        self::assertMatchesRegularExpression( $pattern, $string, $message );
    }
}
```

### Supported ways of calling the assertions

By default, PHPUnit supports [four ways of calling assertions]:
1. **As a method in the `TestCase` class - `$this->assertSomething()`.**
2. **Statically as a method in the `TestCase` class - `self/static/parent::assertSomething()`.**
3. Statically as a method of the `Assert` class - `Assert::assertSomething()`.
4. As a global function - `assertSomething()`.

The polyfills in this library support the first two ways of calling the assertions as those are the most commonly used type of assertion calls.

For the polyfills to work, a test class is **required** to be a (grand-)child of the PHPUnit native `TestCase` class.

[four ways of calling assertions]: https://docs.phpunit.de/en/11.5/assertions.html#static-vs-non-static-usage-of-assertion-methods

### Use with PHPUnit < 7.5.0

If your library still needs to support PHP < 7.1 and therefore needs PHPUnit < 7 for testing, there are a few caveats when using the traits stand-alone as we then enter "double-polyfill" territory.

To prevent _"conflicting method names"_ errors when a trait is `use`d multiple times in a class, the traits offered here do not attempt to solve this.

You will need to make sure to `use` any additional traits needed for the polyfills to work.

| PHPUnit   | When `use`-ing this trait   | You also need to `use` this trait |
| --------- | --------------------------- | --------------------------------- |
| 6.4 < 7.5 | `AssertIgnoringLineEndings` | `AssertStringContains`            |

_**Note: this only applies to the stand-alone use of the traits. The [`TestCase` classes](#testcases) provided by this library already take care of this automatically.**_

Code example for a test using the `AssertIgnoringLineEndings` trait, which needs to be able to run on PHPUnit 6.4:
```php
<?php

namespace Vendor\YourPackage\Tests;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

class FooTest extends TestCase
{
    use AssertIgnoringLineEndings;
    use AssertStringContains;

    public function testSomething()
    {
        $this->assertStringContainsStringIgnoringLineEndings(
            "something\nelse",
            "this is something\r\nelse"
        );
    }
}
```


Features
--------

### Polyfill traits

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertIsType`

Polyfills the following methods:

|                                |                                   |
| ------------------------------ | --------------------------------- |
| [`Assert::assertIsArray()`]    | [`Assert::assertIsNotArray()`]    |
| [`Assert::assertIsBool()`]     | [`Assert::assertIsNotBool()`]     |
| [`Assert::assertIsFloat()`]    | [`Assert::assertIsNotFloat()`]    |
| [`Assert::assertIsInt()`]      | [`Assert::assertIsNotInt()`]      |
| [`Assert::assertIsNumeric()`]  | [`Assert::assertIsNotNumeric()`]  |
| [`Assert::assertIsObject()`]   | [`Assert::assertIsNotObject()`]   |
| [`Assert::assertIsResource()`] | [`Assert::assertIsNotResource()`] |
| [`Assert::assertIsString()`]   | [`Assert::assertIsNotString()`]   |
| [`Assert::assertIsScalar()`]   | [`Assert::assertIsNotScalar()`]   |
| [`Assert::assertIsCallable()`] | [`Assert::assertIsNotCallable()`] |
| [`Assert::assertIsIterable()`] | [`Assert::assertIsNotIterable()`] |

These methods were introduced in PHPUnit 7.5.0 as alternatives to the `Assert::assertInternalType()` and `Assert::assertNotInternalType()` methods, which were soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

[`Assert::assertIsArray()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertisarray
[`Assert::assertIsNotArray()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertisarray
[`Assert::assertIsBool()`]:        https://docs.phpunit.de/en/11.5/assertions.html#assertisbool
[`Assert::assertIsNotBool()`]:     https://docs.phpunit.de/en/11.5/assertions.html#assertisbool
[`Assert::assertIsFloat()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertisfloat
[`Assert::assertIsNotFloat()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertisfloat
[`Assert::assertIsInt()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertisint
[`Assert::assertIsNotInt()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertisint
[`Assert::assertIsNumeric()`]:     https://docs.phpunit.de/en/11.5/assertions.html#assertisnumeric
[`Assert::assertIsNotNumeric()`]:  https://docs.phpunit.de/en/11.5/assertions.html#assertisnumeric
[`Assert::assertIsObject()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertisobject
[`Assert::assertIsNotObject()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertisobject
[`Assert::assertIsResource()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertisresource
[`Assert::assertIsNotResource()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertisresource
[`Assert::assertIsString()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertisstring
[`Assert::assertIsNotString()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertisstring
[`Assert::assertIsScalar()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertisscalar
[`Assert::assertIsNotScalar()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertisscalar
[`Assert::assertIsCallable()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertiscallable
[`Assert::assertIsNotCallable()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertiscallable
[`Assert::assertIsIterable()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertisiterable
[`Assert::assertIsNotIterable()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertisiterable

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains`

Polyfills the following methods:

|                                                      |                                                         |
| ---------------------------------------------------- | ------------------------------------------------------- |
| [`Assert::assertStringContainsString()`]             | [`Assert::assertStringNotContainsString()`]             |
| [`Assert::assertStringContainsStringIgnoringCase()`] | [`Assert::assertStringNotContainsStringIgnoringCase()`] |

These methods were introduced in PHPUnit 7.5.0 as alternatives to using `Assert::assertContains()` and `Assert::assertNotContains()` with string haystacks. Passing string haystacks to these methods was soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

[`Assert::assertStringContainsString()`]:                https://docs.phpunit.de/en/11.5/assertions.html#assertstringcontainsstring
[`Assert::assertStringNotContainsString()`]:             https://docs.phpunit.de/en/11.5/assertions.html#assertstringcontainsstring
[`Assert::assertStringContainsStringIgnoringCase()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertstringcontainsstringignoringcase
[`Assert::assertStringNotContainsStringIgnoringCase()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertstringcontainsstringignoringcase

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations`

Polyfills the following methods:

|                                          |                                             |
| ---------------------------------------- | ------------------------------------------- |
| [`Assert::assertEqualsCanonicalizing()`] | [`Assert::assertNotEqualsCanonicalizing()`] |
| [`Assert::assertEqualsIgnoringCase()`]   | [`Assert::assertNotEqualsIgnoringCase()`]   |
| [`Assert::assertEqualsWithDelta()`]      | [`Assert::assertNotEqualsWithDelta()`]      |

These methods were introduced in PHPUnit 7.5.0 as alternatives to using `Assert::assertEquals()` and `Assert::assertNotEquals()` with these optional parameters. Passing the respective optional parameters to these methods was soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

[`Assert::assertEqualsCanonicalizing()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertequalscanonicalizing
[`Assert::assertNotEqualsCanonicalizing()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertequalscanonicalizing
[`Assert::assertEqualsIgnoringCase()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertequalsignoringcase
[`Assert::assertNotEqualsIgnoringCase()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertequalsignoringcase
[`Assert::assertEqualsWithDelta()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertequalswithdelta
[`Assert::assertNotEqualsWithDelta()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertequalswithdelta


#### PHPUnit < 8.4.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches`

Polyfills the [`TestCase::expectExceptionMessageMatches()`] method.

This method was introduced in PHPUnit 8.4.0 to improve the name of the `TestCase::expectExceptionMessageRegExp()` method.
The `TestCase::expectExceptionMessageRegExp()` method was soft deprecated in PHPUnit 8.4.0, hard deprecated (warning) in PHPUnit 8.5.3 and removed in PHPUnit 9.0.0.

[`TestCase::expectExceptionMessageMatches()`]: https://docs.phpunit.de/en/11.5/writing-tests-for-phpunit.html#expecting-exceptions

#### PHPUnit < 8.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations`

Polyfills the following methods:

|                                                    |                                                       |
| -------------------------------------------------- | ----------------------------------------------------- |
| [`Assert::assertFileEqualsCanonicalizing()`]       | [`Assert::assertFileNotEqualsCanonicalizing()`]       |
| [`Assert::assertFileEqualsIgnoringCase()`]         | [`Assert::assertFileNotEqualsIgnoringCase()`]         |
| [`Assert::assertStringEqualsFileCanonicalizing()`] | [`Assert::assertStringNotEqualsFileCanonicalizing()`] |
| [`Assert::assertStringEqualsFileIgnoringCase()`]   | [`Assert::assertStringNotEqualsFileIgnoringCase()`]   |

These methods were introduced in PHPUnit 8.5.0 as alternatives to using `Assert::assertFileEquals()` and `Assert::assertFileNotEquals()` with these optional parameters. Passing the respective optional parameters to these methods was hard deprecated in PHPUnit 8.5.0 and removed in PHPUnit 9.0.0.

[`Assert::assertFileEqualsCanonicalizing()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertFileNotEqualsCanonicalizing()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertFileEqualsIgnoringCase()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertFileNotEqualsIgnoringCase()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertStringEqualsFileCanonicalizing()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertStringNotEqualsFileCanonicalizing()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertStringEqualsFileIgnoringCase()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals
[`Assert::assertStringNotEqualsFileIgnoringCase()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertfileequals

#### PHPUnit < 9.0.0: `Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations`

Polyfills the following methods:

|                                   |                                 |
| --------------------------------- | ------------------------------- |
| `Assert::equalToCanonicalizing()` | `Assert::equalToIgnoringCase()` |
| `Assert::equalToWithDelta()`      |                                 |

These methods, which are typically used to verify parameters passed to Mock Objects, were introduced in PHPUnit 9.0.0 as alternatives to using `Assert::EqualTo()` with these optional parameters. Support for passing the respective optional parameters to `Assert::EqualTo()` was removed in PHPUnit 9.0.0.

#### PHPUnit < 9.1.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames`

Polyfills the following renamed methods:
* [`Assert::assertIsNotReadable()`], introduced as alternative for `Assert::assertNotIsReadable()`.
* [`Assert::assertIsNotWritable()`], introduced as alternative for `Assert::assertNotIsWritable()`.
* [`Assert::assertDirectoryDoesNotExist()`], introduced as alternative for `Assert::assertDirectoryNotExists()`.
* [`Assert::assertDirectoryIsNotReadable()`], introduced as alternative for `Assert::assertDirectoryNotIsReadable()`.
* [`Assert::assertDirectoryIsNotWritable()`], introduced as alternative for `Assert::assertDirectoryNotIsWritable()`.
* [`Assert::assertFileDoesNotExist()`], introduced as alternative for `Assert::assertFileNotExists()`.
* [`Assert::assertFileIsNotReadable()`], introduced as alternative for `Assert::assertFileNotIsReadable()`.
* [`Assert::assertFileIsNotWritable()`], introduced as alternative for `Assert::assertFileNotIsWritable()`.
* [`Assert::assertMatchesRegularExpression()`], introduced as alternative for `Assert::assertRegExp()`.
* [`Assert::assertDoesNotMatchRegularExpression()`], introduced as alternative for `Assert::assertNotRegExp()`.

These methods were introduced in PHPUnit 9.1.0.
The original methods these new methods replace were hard deprecated in PHPUnit 9.1.0 and removed in PHPUnit 10.0.0.

[`Assert::assertIsNotReadable()`]:                 https://docs.phpunit.de/en/11.5/assertions.html#assertisreadable
[`Assert::assertIsNotWritable()`]:                 https://docs.phpunit.de/en/11.5/assertions.html#assertiswritable
[`Assert::assertDirectoryDoesNotExist()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertdirectoryexists
[`Assert::assertDirectoryIsNotReadable()`]:        https://docs.phpunit.de/en/11.5/assertions.html#assertdirectoryisreadable
[`Assert::assertDirectoryIsNotWritable()`]:        https://docs.phpunit.de/en/11.5/assertions.html#assertdirectoryiswritable
[`Assert::assertFileDoesNotExist()`]:              https://docs.phpunit.de/en/11.5/assertions.html#assertfileexists
[`Assert::assertFileIsNotReadable()`]:             https://docs.phpunit.de/en/11.5/assertions.html#assertfileisreadable
[`Assert::assertFileIsNotWritable()`]:             https://docs.phpunit.de/en/11.5/assertions.html#assertfileiswritable
[`Assert::assertMatchesRegularExpression()`]:      https://docs.phpunit.de/en/11.5/assertions.html#assertmatchesregularexpression
[`Assert::assertDoesNotMatchRegularExpression()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertmatchesregularexpression

#### PHPUnit < 9.3.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource`

Polyfills the following methods:

|                                      |                                         |
| ------------------------------------ | --------------------------------------- |
| [`Assert::assertIsClosedResource()`] | [`Assert::assertIsNotClosedResource()`] |

These methods were introduced in PHPUnit 9.3.0.

[`Assert::assertIsClosedResource()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertisresource
[`Assert::assertIsNotClosedResource()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertisresource

Additionally, this trait contains a helper method `shouldClosedResourceAssertionBeSkipped()`.

Due to some bugs in PHP itself, the "is closed resource" determination cannot always be done reliably, most notably for the `libxml` extension.

This helper function can determine whether or not the current "value under test" in combination with the PHP version on which the test is being run is affected by these bugs.

> :warning: The PHPUnit native implementation of these assertions is also affected by these bugs!
The `shouldClosedResourceAssertionBeSkipped()` helper method is therefore available cross-version.

Usage examples:
```php
// Example: skipping the test completely.
if ( $this->shouldClosedResourceAssertionBeSkipped( $actual ) === true ) {
    $this->markTestSkipped('assertIs[Not]ClosedResource() cannot determine whether this resource is'
        . ' open or closed due to bugs in PHP (PHP ' . \PHP_VERSION . ').');
}

// Example: selectively skipping the assertion.
if ( self::shouldClosedResourceAssertionBeSkipped( $actual ) === false ) {
    $this->assertIsClosedResource( $actual );
}
```

> :point_right: While this polyfill is tested extensively, testing for these kind of bugs _exhaustively_ is _hard_.
> Please [report any bugs](https://github.com/Yoast/PHPUnit-Polyfills/issues/new/choose) found and include a clear code sample to reproduce the issue.

#### PHPUnit < 9.4.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals`

Polyfills the [`Assert::assertObjectEquals()`] method to verify two (value) objects are considered equal.
This assertion expects an object to contain a comparator method in the object itself. This comparator method is subsequently called to verify the "equalness" of the objects.

The `assertObjectEquals()` assertion was introduced in PHPUnit 9.4.0.

> :information_source: In PHPUnit Polyfills 1.x and 2.x, the polyfill for this assertion had [some limitations][assertobjectequals-limitations]. These limitations are no longer present in PHPUnit Polyfills 3.x and the assertion now matches the PHPUnit native implementation.

[`Assert::assertObjectEquals()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertobjectequals
[assertobjectequals-limitations]: https://github.com/Yoast/PHPUnit-Polyfills/?tab=readme-ov-file#phpunit--940-yoastphpunitpolyfillspolyfillsassertobjectequals

#### PHPUnit < 10.0.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings`

Polyfills the following methods:

|                                                           |                                                             |
| --------------------------------------------------------- | ----------------------------------------------------------- |
| [`Assert::assertStringEqualsStringIgnoringLineEndings()`] | [`Assert::assertStringContainsStringIgnoringLineEndings()`] |

These methods were introduced in PHPUnit 10.0.0.

[`Assert::assertStringEqualsStringIgnoringLineEndings()`]:   https://docs.phpunit.de/en/11.5/assertions.html#assertstringequalsstringignoringlineendings
[`Assert::assertStringContainsStringIgnoringLineEndings()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertstringcontainsstring

#### PHPUnit < 10.0.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertIsList`

Polyfills the following method:

|                            |
| -------------------------- |
| [`Assert::assertIsList()`] |

This method was introduced in PHPUnit 10.0.0.

[`Assert::assertIsList()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertislist

#### PHPUnit < 10.1.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty`

Polyfills the following methods:

|                                       |                                          |
| ------------------------------------- | ---------------------------------------- |
| [`Assert::assertObjectHasProperty()`] | [`Assert::assertObjectNotHasProperty()`] |

These methods were introduced in PHPUnit 10.1.0 as alternatives to the `Assert::assertObjectHasAttribute()` and `Assert::assertObjectNotHasAttribute()` methods, which were hard deprecated (warning) in PHPUnit 9.6.1 and removed in PHPUnit 10.0.0.

These methods were later backported to the PHPUnit 9 branch and included in the PHPUnit 9.6.11 release.

[`Assert::assertObjectHasProperty()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertobjecthasproperty
[`Assert::assertObjectNotHasProperty()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertobjecthasproperty

#### PHPUnit < 11.0.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys`

Polyfills the following methods:

|                                                                      |                                                               |
| -------------------------------------------------------------------- | ------------------------------------------------------------- |
| [`Assert::assertArrayIsEqualToArrayOnlyConsideringListOfKeys()`]     | [`Assert::assertArrayIsEqualToArrayIgnoringListOfKeys()`]     |
| [`Assert::assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys()`] | [`Assert::assertArrayIsIdenticalToArrayIgnoringListOfKeys()`] |

These methods were introduced in PHPUnit 11.0.0.

This functionality resembles the functionality previously offered by the `Assert::assertArraySubset()` assertion, which was removed in PHPUnit 9.0.0, but with higher precision.

Refactoring tests which still use `Assert::assertArraySubset()` to use the new assertions should be considered as an upgrade path.

[`Assert::assertArrayIsEqualToArrayOnlyConsideringListOfKeys()`]:     https://docs.phpunit.de/en/11.5/assertions.html#assertarrayisequaltoarrayonlyconsideringlistofkeys
[`Assert::assertArrayIsEqualToArrayIgnoringListOfKeys()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertarrayisequaltoarrayignoringlistofkeys
[`Assert::assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertarrayisidenticaltoarrayonlyconsideringlistofkeys
[`Assert::assertArrayIsIdenticalToArrayIgnoringListOfKeys()`]:        https://docs.phpunit.de/en/11.5/assertions.html#assertarrayisidenticaltoarrayignoringlistofkeys

#### PHPUnit < 11.0.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation`

|                                              |                                                     |
| -------------------------------------------- | --------------------------------------------------- |
| [`TestCase::expectUserDeprecationMessage()`] | [`TestCase::expectUserDeprecationMessageMatches()`] |

These methods were introduced in PHPUnit 11.0.0.

This functionality resembles the functionality previously offered by the `TestCase::expectDeprecationMessage()` and `TestCase::expectDeprecationMessageMatches()` methods, which were removed in PHPUnit 10.0.0.

The polyfill use the old methods under the hood for PHPUnit <= 9, however, there are some pertinent differences in behaviour between the old and the new methods, which users of the polyfill should be aware of.

| PHPUnit <= 9.x | PHPUnit >= 11.0 |
| -------------- | --------------- |
| Only one deprecation can be expected per test | Multiple deprecations can be expected per test |
| The test stops running as soon as the deprecation message has been seen | The test will be executed completely, independently of the deprecation notice |
| The message passed to `expectUserDeprecationMessage()` will be compared as a substring | The message passed to `expectUserDeprecationMessage()` must be an exact match |
| Can expect both PHP native and user-land deprecation notices | Can only expect user-land deprecation notices, i.e. `E_USER_DEPRECATED`, not `E_DEPRECATED` |

Please keep these differences in mind when writing tests using the `expectUserDeprecationMessage*()` methods.

Note: on PHPUnit 9.5.x, when using the `expectUserDeprecationMessage*()` expectations, a "_Expecting E_DEPRECATED and E_USER_DEPRECATED is deprecated and will no longer be possible in PHPUnit 10._" deprecation will be shown in the test output.
As long at the actual test uses the `expectUserDeprecationMessage*()` expectations, this depreation message can be safely ignored.

> :information_source: Important: when using the `expectUserDeprecationMessage*()` expectation(s) in a test, the test should be annotated with a [`#[IgnoreDeprecations]`][ignoredeprecations-attribute] attribute.

[`TestCase::expectUserDeprecationMessage()`]:        https://docs.phpunit.de/en/11.5/error-handling.html#expecting-deprecations-e-user-deprecated
[`TestCase::expectUserDeprecationMessageMatches()`]: https://docs.phpunit.de/en/11.5/error-handling.html#expecting-deprecations-e-user-deprecated
[ignoredeprecations-attribute]:                      https://docs.phpunit.de/en/11.5/attributes.html#ignoredeprecations

#### PHPUnit < 11.2.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals`

Polyfills the [`Assert::assertObjectNotEquals()`] method to verify two (value) objects are **_not_** considered equal.
This is the sister-method to the PHPUnit 9.4+ `Assert::assertObjectEquals()` method.

This assertion expects an object to contain a comparator method in the object itself. This comparator method is subsequently called to verify the "equalness" of the objects.

The `assertObjectNotEquals()` assertion was introduced in PHPUnit 11.2.0.

[`Assert::assertObjectNotEquals()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertobjectequals

#### PHPUnit < 11.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly`

Polyfills the following methods:

|                                                  |                                                     |
| ------------------------------------------------ | --------------------------------------------------- |
| [`Assert::assertContainsOnlyArray()`]            | [`Assert::assertContainsNotOnlyArray()`]            |
| [`Assert::assertContainsOnlyBool()`]             | [`Assert::assertContainsNotOnlyBool()`]             |
| [`Assert::assertContainsOnlyCallable()`]         | [`Assert::assertContainsNotOnlyCallable()`]         |
| [`Assert::assertContainsOnlyFloat()`]            | [`Assert::assertContainsNotOnlyFloat()`]            |
| [`Assert::assertContainsOnlyInt()`]              | [`Assert::assertContainsNotOnlyInt()`]              |
| [`Assert::assertContainsOnlyIterable()`]         | [`Assert::assertContainsNotOnlyIterable()`]         |
| [`Assert::assertContainsOnlyNull()`]             | [`Assert::assertContainsNotOnlyNull()`]             |
| [`Assert::assertContainsOnlyNumeric()`]          | [`Assert::assertContainsNotOnlyNumeric()`]          |
| [`Assert::assertContainsOnlyObject()`]           | [`Assert::assertContainsNotOnlyObject()`]           |
| [`Assert::assertContainsOnlyResource()`]         | [`Assert::assertContainsNotOnlyResource()`]         |
| [`Assert::assertContainsOnlyClosedResource()`] * | [`Assert::assertContainsNotOnlyClosedResource()`] * |
| [`Assert::assertContainsOnlyScalar()`]           | [`Assert::assertContainsNotOnlyScalar()`]           |
| [`Assert::assertContainsOnlyString()`]           | [`Assert::assertContainsNotOnlyString()`]           |
|                                                  | [`Assert::assertContainsNotOnlyInstancesOf()`]      |


These methods were introduced in PHPUnit 11.5.0 as alternatives to the `Assert::assertContainsOnly()` and `Assert::assertNotContainsOnly()` methods, which were soft deprecated in PHPUnit 11.5.0, hard deprecated (warning) in PHPUnit 12.0.0 and will be removed in PHPUnit 13.0.0.

* The `assertContains[Not]OnlyClosedResource()` methods are affected by issues in older PHP versions. Please read the [warning about checking for closed resources and how to optional skip such tests](https://github.com/Yoast/PHPUnit-Polyfills/tree/1.x?tab=readme-ov-file#phpunit--930-yoastphpunitpolyfillspolyfillsassertclosedresource).

[`Assert::assertContainsOnlyArray()`]:             https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyarray
[`Assert::assertContainsNotOnlyArray()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyarray
[`Assert::assertContainsOnlyBool()`]:              https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlybool
[`Assert::assertContainsNotOnlyBool()`]:           https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlybool
[`Assert::assertContainsOnlyCallable()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlycallable
[`Assert::assertContainsNotOnlyCallable()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlycallable
[`Assert::assertContainsOnlyFloat()`]:             https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyfloat
[`Assert::assertContainsNotOnlyFloat()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyfloat
[`Assert::assertContainsOnlyInt()`]:               https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyint
[`Assert::assertContainsNotOnlyInt()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyint
[`Assert::assertContainsOnlyIterable()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyiterable
[`Assert::assertContainsNotOnlyIterable()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyiterable
[`Assert::assertContainsOnlyNull()`]:              https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlynull
[`Assert::assertContainsNotOnlyNull()`]:           https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlynull
[`Assert::assertContainsOnlyNumeric()`]:           https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlynumeric
[`Assert::assertContainsNotOnlyNumeric()`]:        https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlynumeric
[`Assert::assertContainsOnlyObject()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyobject
[`Assert::assertContainsNotOnlyObject()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyobject
[`Assert::assertContainsOnlyResource()`]:          https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyresource
[`Assert::assertContainsNotOnlyResource()`]:       https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyresource
[`Assert::assertContainsOnlyClosedResource()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyclosedresource
[`Assert::assertContainsNotOnlyClosedResource()`]: https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyclosedresource
[`Assert::assertContainsOnlyScalar()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyscalar
[`Assert::assertContainsNotOnlyScalar()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyscalar
[`Assert::assertContainsOnlyString()`]:            https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlystring
[`Assert::assertContainsNotOnlyString()`]:         https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlystring
[`Assert::assertContainsNotOnlyInstancesOf()`]:    https://docs.phpunit.de/en/11.5/assertions.html#assertcontainsonlyinstancesof


### TestCases

PHPUnit 8.0.0 introduced a `void` return type declaration to the ["fixture" methods] - `setUpBeforeClass()`, `setUp()`, `tearDown()` and `tearDownAfterClass()`.
As the `void` return type was not introduced until PHP 7.1, this makes it more difficult to create cross-version compatible tests when using fixtures, due to signature mismatches.

["fixture" methods]: https://docs.phpunit.de/en/11.5/fixtures.html

This library contains two basic `TestCase` options to overcome this issue.

#### Option 1: `Yoast\PHPUnitPolyfills\TestCases\TestCase`

This `TestCase` overcomes the signature mismatch by having two versions. The correct one will be loaded depending on the PHPUnit version being used.

When using this `TestCase`, if an individual test, or another `TestCase` which extends this `TestCase`, needs to overload any of the "fixture" methods, it should do so by using a snake_case variant of the original fixture method name, i.e. `set_up_before_class()`, `set_up()`, `assert_pre_conditions()`, `assert_post_conditions()`, `tear_down()` and `tear_down_after_class()`.

The snake_case methods will automatically be called by PHPUnit.

> **IMPORTANT:** The snake_case methods should **not** call the PHPUnit parent, i.e. do **not** use `parent::setUp()` from within an overloaded `set_up()` method.
> If necessary, _DO_ call `parent::set_up()`.

```php
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class MyTest extends TestCase {
    public static function set_up_before_class() {
        parent::set_up_before_class();

        // Set up a database connection or other fixture which needs to be available.
    }

    protected function set_up() {
        parent::set_up();

        // Set up function mocks which need to be available for all tests in this class.
    }

    protected function assert_pre_conditions() {
        parent::assert_pre_conditions();

        // Perform assertions shared by all tests of a test case (before the test).
    }

    protected function assert_post_conditions() {
        // Performs assertions shared by all tests of a test case (after the test).

        parent::assert_post_conditions();
    }

    protected function tear_down() {
        // Any clean up needed related to `set_up()`.

        parent::tear_down();
    }

    public static function tear_down_after_class() {
        // Close database connection and other clean up related to `set_up_before_class()`.

        parent::tear_down_after_class();
    }
}
```

#### Option 2: `Yoast\PHPUnitPolyfills\TestCases\XTestCase`

This `TestCase` overcomes the signature mismatch by using the PHPUnit `@before[Class]` and `@after[Class]` annotations in combination with different methods names, i.e. `setUpFixturesBeforeClass()`, `setUpFixtures()`, `tearDownFixtures()` and `tearDownFixturesAfterClass()`.

When using this TestCase, overloaded fixture methods need to use the [`@beforeClass`], [`@before`], [`@after`] and [`@afterClass`] annotations.
The naming of the overloaded methods is open as long as the method names don't conflict with the PHPUnit native method names.

[`@beforeClass`]: https://docs.phpunit.de/en/11.5/annotations.html#beforeclass
[`@before`]:      https://docs.phpunit.de/en/11.5/annotations.html#before
[`@after`]:       https://docs.phpunit.de/en/11.5/annotations.html#after
[`@afterClass`]:  https://docs.phpunit.de/en/11.5/annotations.html#afterclass

```php
use Yoast\PHPUnitPolyfills\TestCases\XTestCase;

class MyTest extends XTestCase {
    /**
     * @beforeClass
     */
    public static function setUpFixturesBeforeClass() {
        parent::setUpFixturesBeforeClass();

        // Set up a database connection or other fixture which needs to be available.
    }

    /**
     * @before
     */
    protected function setUpFixtures() {
        parent::setUpFixtures();

        // Set up function mocks which need to be available for all tests in this class.
    }

    /**
     * @after
     */
    protected function tearDownFixtures() {
        // Any clean up needed related to `setUpFixtures()`.

        parent::tearDownFixtures();
    }

    /**
     * @afterClass
     */
    public static function tearDownFixturesAfterClass() {
        // Close database connection and other clean up related to `setUpFixturesBeforeClass()`.

        parent::tearDownFixturesAfterClass();
    }
}
```

### TestListener

> :warning: **Important** :warning:
>
> The TestListener polyfill in PHPUnit Polyfills 2.0/3.0 is [not (yet) compatible with PHPUnit 10.x/11.x][polyfill-ticket].
>
> If you need the TestListener polyfill, it is recommended to stay on the PHPUnit Polyfills 1.x series for the time being and to watch and upvote the [related ticket][polyfill-ticket].
>
> The below documentation is for the PHPUnit 6.x-9.x TestListener polyfill implementation.

[polyfill-ticket]: https://github.com/Yoast/PHPUnit-Polyfills/issues/128

The method signatures in the PHPUnit `TestListener` interface have changed a number of times across versions.
Additionally, the use of the TestListener principle has been deprecated in PHPUnit 7 in favour of using the [TestRunner hook interfaces](https://docs.phpunit.de/en/7.5/extending-phpunit.html#extending-the-testrunner).

> Note: while deprecated in PHPUnit 7, the TestListener interface has not yet been removed and is still supported in PHPUnit 9.x.

If your test suite does not need to support PHPUnit < 7, it is strongly recommended to use the TestRunner hook interfaces extensions instead.

However, for test suites that still need to support PHPUnit 6 or lower, implementing the `TestListener` interface is the only viable option.

#### `Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation`

This `TestListenerDefaultImplementation` trait overcomes the signature mismatches by having multiple versions and loading the correct one depending on the PHPUnit version being used.

Similar to the `TestCase` implementation, snake_case methods without type declarations are used to get round the signature mismatches. The snake_case methods will automatically be called.

| PHPUnit native method name | Replacement                             |
| -------------------------- | --------------------------------------- |
| `addError()`               | `add_error($test, $e, $time)`           |
| `addWarning()`             | `add_warning($test, $e, $time)`         |
| `addFailure()`             | `add_failure($test, $e, $time)`         |
| `addIncompleteTest()`      | `add_incomplete_test($test, $e, $time)` |
| `addRiskyTest()`           | `add_risky_test($test, $e, $time)`      |
| `addSkippedTest()`         | `add_skipped_test($test, $e, $time)`    |
| `startTestSuite()`         | `start_test_suite($suite)`              |
| `endTestSuite()`           | `end_test_suite($suite)`                |
| `startTest()`              | `start_test($test)`                     |
| `endTest()`                | `end_test($test, $time)`                |

Implementations of the `TestListener` interface may be using any of the following patterns:
```php
// PHPUnit 6.
class MyTestListener extends \PHPUnit\Framework\BaseTestListener {}

// PHPUnit 7+.
class MyTestListener implements \PHPUnit\Framework\TestListener {
    use \PHPUnit\Framework\TestListenerDefaultImplementation;
}
```

Replace these with:
```php
use PHPUnit\Framework\TestListener;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation;

class MyTestListener implements TestListener {
    use TestListenerDefaultImplementation;

    // Implement any of the snakecase methods, for example:
    public function add_error( $test, $e, $time ) {
        // Do something when PHPUnit encounters an error.
    }
}
```


Frequently Asked Questions
--------------------------

### Q: Will this package polyfill functionality which was removed from PHPUnit ?

As a rule of thumb, removed functionality will **not** be polyfilled in this package.

For frequently used, removed PHPUnit functionality, "helpers" may be provided. These _helpers_ are only intended as an interim solution to allow users of this package more time to refactor their tests away from the removed functionality.

#### Removed functionality without PHPUnit native replacement

| PHPUnit | Removed               | Issue          | Remarks                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| ------- | --------------------- | -------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 9.0.0   | `assertArraySubset()` | [#1][issue #1] | The [`dms/phpunit-arraysubset-asserts`](https://packagist.org/packages/dms/phpunit-arraysubset-asserts) package polyfills this functionality.<br/>As of [version 0.3.0](https://github.com/rdohms/phpunit-arraysubset-asserts/releases/tag/v0.3.0) this package can be installed in combination with PHP 5.4 - current and PHPUnit 4.8.36/5.7.21 - current.<br/>Alternatively, tests can be refactored using the patterns outlined in [issue #1]. |

[issue #1]: https://github.com/Yoast/PHPUnit-Polyfills/issues/1

### Q: Can this library be used when the tests are being run via a PHPUnit Phar file ?

Yes, this package can also be used when running tests via a PHPUnit Phar file.

In that case, make sure that the `phpunitpolyfills-autoload.php` file is explicitly `require`d in the test bootstrap file.
(Not necessary when the Composer `vendor/autoload.php` file is used as, or `require`d in, the test bootstrap.)


### Q: How do I run my tests when the library is installed via the GitHub Actions `setup-php` action ?

As of [shivammathur/setup-php](https://github.com/shivammathur/setup-php) version [2.15.0](https://github.com/shivammathur/setup-php/releases/tag/2.15.0), the PHPUnit Polyfills are available as one of the tools which can be installed directly by the Setup-PHP GitHub action runner.

```yaml
- name: Setup PHP with tools
  uses: shivammathur/setup-php@v2
  with:
    php-version: '8.0'
    tools: phpunit-polyfills
```

The above step will install both the PHPUnit Polyfills, as well as PHPUnit, as Composer global packages.

After this step has run, you can run PHPUnit, like you would normally, by using `phpunit`.
```yaml
- name: Run tests
  run: phpunit
```

:point_right: If you rely on Composer for autoloading your project files, you will still need to run `composer dump-autoload --dev` and include the project local `vendor/autoload.php` file as/in your test bootstrap.

> :mortar_board: Why this works:
>
> Composer will place all files in the global Composer `bin` directory in the system path and the Composer installed PHPUnit version will load the Composer global `autoload.php` file, which will automatically also load the PHPUnit Polyfills.

Now you may wonder, _"what about if I explicitly request both `phpunit` as well as `phpunit-polyfills` in `tools`?"_

In that case, when you run `phpunit`, the PHPUnit PHAR will not know how to locate the PHPUnit Polyfills, so you will need to do some wizardry in your test bootstrap to get things working.


### Q: How can I verify the version used of the PHPUnit Polyfills library ?

For complex test setups, like when the Polyfills are provided via a test suite dependency, or may already be loaded via an overarching project, it can be useful to be able to check that a version of the package is used which complies with the requirements for your test suite.

As of version 1.0.1, the PHPUnit Polyfills `Autoload` class contains a version number which can be used for this purpose.

Typically such a check would be done in the test suite bootstrap file and could look something like this:
```php
if ( class_exists( '\Yoast\PHPUnitPolyfills\Autoload' ) === false ) {
    require_once 'vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
}

$versionRequirement = '1.0.1';
if ( defined( '\Yoast\PHPUnitPolyfills\Autoload::VERSION' ) === false
    || version_compare( \Yoast\PHPUnitPolyfills\Autoload::VERSION, $versionRequirement, '<' )
) {
    echo 'Error: Version mismatch detected for the PHPUnit Polyfills.',
        ' Please ensure that PHPUnit Polyfills ', $versionRequirement,
        ' or higher is loaded.', PHP_EOL;
    exit(1);
} else {
    echo 'Error: Please run `composer update -W` before running the tests.' . PHP_EOL;
    echo 'You can still use a PHPUnit phar to run them,',
        ' but the dependencies do need to be installed.', PHP_EOL;
    exit(1);
}
```

### Q: Why don't the PHPUnit Polyfills 3.x versions support running tests on PHPUnit 10 ?

PHPUnit 11.0 introduced the `expectUserDeprecationMessage*()` methods. To polyfill these for PHPUnit 10 would mean that the Polyfills package could no longer be a "drop-in" helper package, but would need to set extra requirements on test suites using the polyfills when used with PHPUnit 10 (like hooking into events or compulsory use of the `TestCase`s provided by this package).

As it was deemed desirable enough to polyfill the methods, the releases from the 3.x branch of the PHPUnit Polyfills do not support running tests on PHPUnit 10.

The impact of this compromise is minimal, as, in the most common case of running the tests with Composer installed dependencies, this just and only means that test runs on PHP 8.1 will use PHPUnit 9 instead of PHPUnit 10. There is no other impact.

Keep in mind that functionality _added_ in PHPUnit 10, is still polyfilled and available in PHPUnit Polyfills 3.x.


Contributing
------------
Contributions to this project are welcome. Clone the repo, branch off from the oldest #.x branch the patch applies to, make your changes, commit them and send in a pull request against the correct #.x branch.

If you are unsure whether the changes you are proposing would be welcome, please open an issue first to discuss your proposal.


License
-------
This code is released under the [BSD-3-Clause License](LICENSE).
