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
    - [Helper traits](#helper-traits)
    - [TestCases](#testcases)
    - [TestListener](#testlistener)
* [Using this library](#using-this-library)
* [Contributing](#contributing)
* [License](#license)


Requirements
-------------------------------------------

* PHP 5.5 or higher.
* PHPUnit 4.8 - 9.x (automatically required via Composer).


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

### Write your tests for PHPUnit 9.x and run them on PHPUnit 4.8 - 9.x

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

#### PHPUnit < 5.0.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertNumericType`

Polyfills the following methods:
|                          |                            |                       |
|--------------------------|----------------------------|-----------------------|
| `Assert::assertFinite()` | `Assert::assertInfinite()` | `Assert::assertNan()` |

These methods were introduced in PHPUnit 5.0.0.

#### PHPUnit < 5.2.0: `Yoast\PHPUnitPolyfills\Polyfills\ExpectException`

Polyfills the following methods:
|                                   |                                            |
|-----------------------------------|--------------------------------------------|
| `TestCase::expectException()`     | `TestCase::expectExceptionMessage()`       |
| `TestCase::expectExceptionCode()` | `TestCase::expectExceptionMessageRegExp()` |

These methods were introduced in PHPUnit 5.2.0 as alternatives to the `Testcase::setExpectedException()` method which was deprecated in PHPUnit 5.2.0 and the `Testcase::setExpectedExceptionRegExp()` method which was deprecated in 5.6.0.
Both these methods were removed in PHPUnit 6.0.0.

#### PHPUnit < 5.6.0: `Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory`

Polyfills the following methods:
|                                       |                                          |
|---------------------------------------|------------------------------------------|
| `Assert::assertIsReadable()`          | `Assert::assertNotIsReadable()`          |
| `Assert::assertIsWritable()`          | `Assert::assertNotIsWritable()`          |
| `Assert::assertDirectoryExists()`     | `Assert::assertDirectoryNotExists()`     |
| `Assert::assertDirectoryIsReadable()` | `Assert::assertDirectoryNotIsReadable()` |
| `Assert::assertDirectoryIsWritable()` | `Assert::assertDirectoryNotIsWritable()` |
| `Assert::assertFileIsReadable()`      | `Assert::assertFileNotIsReadable()`      |
| `Assert::assertFileIsWritable()`      | `Assert::assertFileNotIsWritable()`      |

These methods were introduced in PHPUnit 5.6.0.

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


### Helper traits

#### `Yoast\PHPUnitPolyfills\Helpers\AssertAttributeHelper`

Helper to work around the removal of the `assertAttribute*()` methods.

The `assertAttribute*()` methods were deprecated in PHPUnit 8.x and removed in PHPUnit 9.0.

Public properties can still be tested by accessing them directly:
```php
$this->assertSame( 'value', $obj->propertyName );
```

Protected and private properties can no longer be tested using PHPUnit native functionality.
The reasoning for the removal of these assertion methods is that _private and protected properties are an implementation detail and should not be tested directly, but via methods in the class_.

It is strongly recommended to refactor your tests, and if needs be, your classes to adhere to this.

However, if for some reason the value of `protected` or `private` properties still needs to be tested, this helper can be used to get access to their value and attributes.

The trait contains two helper methods:
* `public static getProperty( object $classInstance, string $propertyName ) : ReflectionProperty`
* `public static getPropertyValue( object $classInstance, string $propertyName ) : mixed`

```php
// Test the value of a protected or private property.
$this->assertSame( 'value', $this->getPropertyValue( $objInstance, $propertyName ) );

// Retrieve a ReflectionProperty object to test other details of the property.
self::assertSame( $propertyName, self::getProperty( $objInstance, $propertyName )->getName() );
```

### TestCases

PHPUnit 8.0.0 introduced a `void` return type declaration to the "fixture" methods - `setUpBeforeClass()`, `setUp()`, `tearDown()` and `tearDownAfterClass()`.
As the `void` return type was not introduced until PHP 7.1, this makes it more difficult to create cross-version compatible tests when using fixtures, due to signature mismatches.

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

### TestListener

The method signatures in the PHPUnit `TestListener` interface have changed a number of times across versions.
Additionally, the use of the TestListener principle has been deprecated in PHPUnit 7 in favour of using the [TestRunner hook interfaces](https://phpunit.readthedocs.io/en/9.3/extending-phpunit.html#extending-the-testrunner).
Note: while deprecated in PHPUnit 7, the TestListener interface has not yet been removed and is still supported in PHPUnit 9.

If your test suite does not need to support PHPUnit < 7, it is strongly recommended to use the TestRunner hook interfaces extensions instead.

However, for test suites that still need to support PHPUnit 6 or lower, implementing the `TestListener` interface is the only viable option.

#### `Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation`

This `TestListenerDefaultImplementation` trait overcomes the signature mismatches by having multiple versions and loading the correct one depending on the PHPUnit version being used.

Similar to the `TestCase` implementation, snake_case methods without type declarations are used to get round the signature mismatches. The snake_case methods will automatically be called.

| PHPUnit native method name | Replacement                             | Notes                                     |
|----------------------------|-----------------------------------------|-------------------------------------------|
| `addError()`               | `add_error($test, $e, $time)`           |                                           |
| `addWarning()`             | `add_warning($test, $e, $time)`         | Introduced in PHPUnit 6.                  |
| `addFailure()`             | `add_failure($test, $e, $time)`         |                                           |
| `addIncompleteTest()`      | `add_incomplete_test($test, $e, $time)` |                                           |
| `addRiskyTest()`           | `add_risky_test($test, $e, $time)`      | Support appears to be flaky on PHPUnit 5. |
| `addSkippedTest()`         | `add_skipped_test($test, $e, $time)`    |                                           |
| `startTestSuite()`         | `start_test_suite($suite)`              |                                           |
| `endTestSuite()`           | `end_test_suite($suite)`                |                                           |
| `startTest()`              | `start_test($test)`                     |                                           |
| `endTest()`                | `end_test($test, $time)`                |                                           |

Implementations of the `TestListener` interface may be using any of the following patterns:
```php
// PHPUnit < 6.
class MyTestListener extends \PHPUnit_Framework_BaseTestListener {}

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


Using this library
-------

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

### Use with PHPUnit < 5.7.0

If your library still needs to support PHP 5.5 and therefore needs PHPUnit 4 for testing, there are a few caveats when using the traits stand-alone as we then enter "double-polyfill" territory.

To prevent "conflicting method names" errors when a trait is `use`d multiple times in a class, the traits offered here do not attempt to solve this.

You will need to make sure to `use` any additional traits needed for the polyfills to work.

| PHPUnit   | When `use`-ing this trait       | You also need to `use` this trait |
|-----------|---------------------------------|-----------------------------------|
| 4.8 < 5.2 | `ExpectExceptionObject`         | `ExpectException`                 |
| 4.8 < 5.2 | `ExpectPHPException`            | `ExpectException`                 |
| 4.8 < 5.2 | `ExpectExceptionMessageMatches` | `ExpectException`                 |
| 4.8 < 5.6 | `AssertionRenames`              | `AssertFileDirectory`             |

_**Note: this only applies to the stand-alone use of the traits. The [`TestCase` classes](#testcases) provided by this library already take care of this automatically.**_

Code example testing for a PHP native warning in a test which needs to be able to run on PHPUnit 4.8:
```php
<?php

namespace Vendor\YourPackage\Tests;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

class FooTest extends TestCase
{
    use ExpectException;
    use ExpectPHPException;

    public function testSomething()
    {
        $this->expectWarningMessage( 'A non-numeric value encountered' );
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
