PHPUnit Polyfills
=====================================================

[![Version](https://poser.pugx.org/yoast/phpunit-polyfills/version)](//packagist.org/packages/yoast/phpunit-polyfills)
[![Travis Build Status](https://travis-ci.com/Yoast/PHPUnit-Polyfills.svg?branch=main)](https://travis-ci.com/Yoast/PHPUnit-Polyfills/branches)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/yoast/phpunit-polyfills.svg?maxAge=3600)](https://packagist.org/packages/yoast/phpunit-polyfills)
[![License: BSD3](https://poser.pugx.org/yoast/phpunit-polyfills/license)](https://github.com/Yoast/PHPUnit-Polyfills/blob/master/LICENSE)


Set of polyfills for changed PHPUnit functionality to allow for creating PHPUnit cross-version compatible tests.

* [Requirements](#requirements)
* [Installation](#installation)
* [Features](#features)
    - [Polyfill traits](#polyfill-traits)
    - [TestCases](#testcases)
* [Using this library](#using-this-library)
* [Contributing](#contributing)
* [License](#license)


Requirements
-------------------------------------------

* PHP 5.6 or higher.
* PHPUnit 5.7 - 9.x (automatically required via Composer).


Installation
-------------------------------------------

To install this package, run:
```bash
composer require --dev yoast/phpunit-polyfills
```

To update this package, run:
```bash
composer update --dev yoast/phpunit-polyfills --with-dependencies
```

This package can also be used when running tests via a PHPUnit Phar file.
In that case, make sure that the `phpunitpolyfills-autoload.php` file is explicitly `require`d in the test bootstrap file.
(Not necessary when the Composer `vendor/autoload.php` file is used as, or `require`d in, the test bootstrap.)


Features
-------------------------------------------

This library is set up to allow for creating PHPUnit cross-version compatible tests.

This library offers a number of polyfills for functionality which was introduced, split up or renamed in PHPUnit.

### Write your tests for PHPUnit 9.x and run them on PHPUnit 5.7 - 9.x

The polyfills have been setup to allow tests to be _forward_-compatible. What that means is, that your tests can use the assertions supported by the _latest_ PHPUnit version, even when running on older PHPUnit versions.

This puts the burden of upgrading to use the syntax of newer PHPUnit versions at the point when you want to start running your tests on a newer version.
By doing so, dropping support for an older PHPUnit version becomes as simple as removing it from the version constraint in your `composer.json` file.

### Supported ways of calling the assertions

By default, PHPUnit supports four ways of calling assertions:
1. As a method in the `TestCase` class - `$this->assertSomething()`.
2. Statically as a method in the `TestCase` class - `self/static/parent::assertSomething()`.
3. Statically as a method of the `Assert` class - `Assert::assertSomething()`.
4. As a global function - `assertSomething()`.

The polyfills in this library support the first two ways of calling the assertions as those are the most commonly used type of assertion calls.

For the polyfills to work, a test class is **required** to be a (grand-)child of the PHPUnit native `TestCase` class.

### Polyfill traits

#### PHPUnit < 6.4.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject`

Polyfills the `TestCase::expectExceptionObject()` method to test all aspects of an `Exception` by passing an object to the method.

This method was introduced in PHPUnit 6.4.0.

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertIsType`

Polyfills the following methods:
|                                 |                                 |                               |
|---------------------------------|---------------------------------|-------------------------------|
| `Assert::assertIsArray()`       | `Assert::assertIsBool()`        | `Assert::assertIsFloat()`     |
| `Assert::assertIsInt()`         | `Assert::assertIsNumeric()`     | `Assert::assertIsObject()`    |
| `Assert::assertIsResource()`    | `Assert::assertIsString()`      | `Assert::assertIsScalar()`    |
| `Assert::assertIsCallable()`    | `Assert::assertIsIterable()`    |                               |
| `Assert::assertIsNotArray()`    | `Assert::assertIsNotBool()`     | `Assert::assertIsNotFloat()`  |
| `Assert::assertIsNotInt()`      | `Assert::assertIsNotNumeric()`  | `Assert::assertIsNotObject()` |
| `Assert::assertIsNotResource()` | `Assert::assertIsNotString()`   | `Assert::assertIsNotScalar()` |
| `Assert::assertIsNotCallable()` | `Assert::assertIsNotIterable()` |                               |

These methods were introduced in PHPUnit 7.5.0 as alternatives to the `Assert::assertInternalType()` and `Assert::assertNotInternalType()` methods, which were soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains`

Polyfills the following methods:
|                                                    |                                                       |
|----------------------------------------------------|-------------------------------------------------------|
| `Assert::assertStringContainsString()`             | `Assert::assertStringNotContainsString()`             |
| `Assert::assertStringContainsStringIgnoringCase()` | `Assert::assertStringNotContainsStringIgnoringCase()` |

These methods were introduced in PHPUnit 7.5.0 as alternatives to using `Assert::assertContains()` and `Assert::assertNotContains()` with string haystacks. Passing string haystacks to these methods was soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

#### PHPUnit < 7.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations`

Polyfills the following methods:
|                                        |                                           |
|----------------------------------------|-------------------------------------------|
| `Assert::assertEqualsCanonicalizing()` | `Assert::assertNotEqualsCanonicalizing()` |
| `Assert::assertEqualsIgnoringCase()`   | `Assert::assertNotEqualsIgnoringCase()`   |
| `Assert::assertEqualsWithDelta()`      | `Assert::assertNotEqualsWithDelta()`      |

These methods were introduced in PHPUnit 7.5.0 as alternatives to using `Assert::assertEquals()` and `Assert::assertNotEquals()` with these optional parameters. Passing the respective optional parameters to these methods was soft deprecated in PHPUnit 7.5.0, hard deprecated (warning) in PHPUnit 8.0.0 and removed in PHPUnit 9.0.0.

#### PHPUnit < 8.4.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException`

Polyfills the following methods:
|                       |                              |                                     |
|-----------------------|------------------------------|-------------------------------------|
| `expectError()`       | `expectErrorMessage()`       | `expectErrorMessageMatches()`       |
| `expectWarning()`     | `expectWarningMessage()`     | `expectWarningMessageMatches()`     |
| `expectNotice()`      | `expectNoticeMessage()`      | `expectNoticeMessageMatches()`      |
| `expectDeprecation()` | `expectDeprecationMessage()` | `expectDeprecationMessageMatches()` |

These method were introduced in PHPUnit 8.4.0 as alternatives to using `TestCase::expectException()` et al for expecting PHP native errors, warnings and notices.
Using `TestCase::expectException*()` for testing PHP native notices was soft deprecated in PHPUnit 8.4.0, hard deprecated (warning) in PHPUnit 9.0.0 and (will be) removed in PHPUnit 10.0.0.

#### PHPUnit < 8.4.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches`

Polyfills the `TestCase::expectExceptionMessageMatches()` method.

This method was introduced in PHPUnit 8.4.0 to improve the name of the `TestCase::expectExceptionMessageRegExp()` method.
The `TestCase::expectExceptionMessageRegExp()` method was soft deprecated in PHPUnit 8.4.0, hard deprecated (warning) in PHPUnit 8.5.3 and removed in PHPUnit 9.0.0.

#### PHPUnit < 8.5.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations`

Polyfills the following methods:
|                                                  |                                                     |
|--------------------------------------------------|-----------------------------------------------------|
| `Assert::assertFileEqualsCanonicalizing()`       | `Assert::assertFileNotEqualsCanonicalizing()`       |
| `Assert::assertFileEqualsIgnoringCase()`         | `Assert::assertFileNotEqualsIgnoringCase()`         |
| `Assert::assertStringEqualsFileCanonicalizing()` | `Assert::assertStringNotEqualsFileCanonicalizing()` |
| `Assert::assertStringEqualsFileIgnoringCase()`   | `Assert::assertStringNotEqualsFileIgnoringCase()`   |

These methods were introduced in PHPUnit 8.5.0 as alternatives to using `Assert::assertFileEquals()` and `Assert::assertFileNotEquals()` with these optional parameters. Passing the respective optional parameters to these methods was hard deprecated in PHPUnit 8.5.0 and removed in PHPUnit 9.0.0.

### PHPUnit < 9.1.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames`

Polyfills the following renamed methods:
* `Assert::assertIsNotReadable()`, introduced as alternative for `Assert::assertNotIsReadable()`.
* `Assert::assertIsNotWritable()`, introduced as alternative for `Assert::assertNotIsWritable()`.
* `Assert::assertDirectoryDoesNotExist()`, introduced as alternative for `Assert::assertDirectoryNotExists()`.
* `Assert::assertDirectoryIsNotReadable()`, introduced as alternative for `Assert::assertDirectoryNotIsReadable()`.
* `Assert::assertDirectoryIsNotWritable()`, introduced as alternative for `Assert::assertDirectoryNotIsWritable()`.
* `Assert::assertFileDoesNotExist()`, introduced as alternative for `Assert::assertFileNotExists()`.
* `Assert::assertFileIsNotReadable()`, introduced as alternative for `Assert::assertFileNotIsReadable()`.
* `Assert::assertFileIsNotWritable()`, introduced as alternative for `Assert::assertFileNotIsWritable()`.
* `Assert::assertMatchesRegularExpression()`, introduced as alternative for `Assert::assertRegExp()`.
* `Assert::assertDoesNotMatchRegularExpression()`, introduced as alternative for `Assert::assertNotRegExp()`.

These methods were introduced in PHPUnit 9.1.0.
The original methods these new methods replace were hard deprecated in PHPUnit 9.1.0 and (will be) removed in PHPUnit 10.0.0.


### TestCases

PHPUnit 8.0.0 introduced a `void` return type declaration to the "fixture" methods - `setUpBeforeClass()`, `setUp()`, `tearDown()` and `tearDownAfterClass()`.
As the `void` return type was not introduced until PHP 7.1, this makes it more difficult to create cross-version compatible tests when using fixtures, due to signature mismatches.

This library contains two basic `TestCase` options to overcome this issue.

#### Option 1: `Yoast\PHPUnitPolyfills\TestCases\TestCase`

This `TestCase` overcomes the signature mismatch by having two versions. The correct one will be loaded depending on the PHPUnit version being used.

When using this `TestCase`, if an individual test, or another `TestCase` which extends this `TestCase`, needs to overload any of the "fixture" methods, it should do so by using a snake_case variant of the original fixture method name, i.e. `set_up_before_class()`, `set_up()`, `tear_down()` and `tear_down_after_class()`.

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

When using this TestCase, overloaded fixture methods need to use the `@beforeClass`, `@before`, `@after` and `@afterClass` annotations.
The naming of the overloaded methods is open as long as the method names don't conflict with the PHPUnit native method names.

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


Using this library
-------

Each of the polyfills has been setup as a trait and can be imported and `use`d in any test file which extends the PHPUnit native `TestCase` class.

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

In that case, all polyfills will be available whenever needed.

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

Contributing
-------
Contributions to this project are welcome. Clone the repo, branch off from `develop`, make your changes, commit them and send in a pull request.

If you are unsure whether the changes you are proposing would be welcome, please open an issue first to discuss your proposal.


License
-------
This code is released under the [BSD-3-Clause License](https://opensource.org/licenses/BSD-3-Clause).
