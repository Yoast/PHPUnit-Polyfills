# Change Log for Yoast PHPUnit Polyfills

All notable changes to this project will be documented in this file.

This projects adheres to [Keep a CHANGELOG](http://keepachangelog.com/) and uses [Semantic Versioning](http://semver.org/).


## [Unreleased]

_Nothing yet._

## [1.0.0] - 2021-06-21

### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource` trait to polyfill the `Assert::assertIsClosedResource()` and `Assert::assertIsNotClosedResource()` methods as introduced in PHPUnit 9.3.0. PR [#27].
* `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals` trait to polyfill the `Assert::assertObjectEquals()` method as introduced in PHPUnit 9.4.0. PR [#38].
    The behaviour of the polyfill closely matches the PHPUnit native implementation, but is not 100% the same.
    Most notably, the polyfill will check the type of the returned value from the comparator method instead of the enforcing a return type declaration of the comparator method.
* `Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations` trait to polyfill the `Assert::equalToCanonicalizing()`, `Assert::equalToIgnoringCase()` and `Assert::equalToWithDelta()` methods as introduced in PHPUnit 9.0.0. PR [#28], props [Marc Siegrist].
* Polyfills for the PHP native `Error` and `TypeError` classes as introduced in PHP 7.0. PR [#36].
* README: FAQ section covering functionality removed from PHPUnit and usage with a Phar.

### Changed
* The minimum supported PHP version has been lowered to PHP 5.4 (was 5.5). PR [#19].
* `XTestCase`: the visibility of the `setUpFixtures()` and the `tearDownFixtures()` methods has been changed to `protected` (was `public`). Issue [#10], PR [#20], props [Mark Baker] for reporting.
* README: re-ordered the sections and various other improvements.
* Initial preparation for PHPUnit 10.0 compatibility.
* General housekeeping.

### Fixed
* Issue [#17] via PR [#18] - `AssertStringContainString`: PHPUnit < 6.4.2 would throw a _"mb_strpos(): empty delimiter"_ PHP warning when the `$needle` passed was an empty string. Props [Gary Jones].

[#10]: https://github.com/Yoast/PHPUnit-Polyfills/issues/10
[#17]: https://github.com/Yoast/PHPUnit-Polyfills/issues/17
[#18]: https://github.com/Yoast/PHPUnit-Polyfills/pull/18
[#19]: https://github.com/Yoast/PHPUnit-Polyfills/pull/19
[#20]: https://github.com/Yoast/PHPUnit-Polyfills/pull/20
[#27]: https://github.com/Yoast/PHPUnit-Polyfills/pull/27
[#28]: https://github.com/Yoast/PHPUnit-Polyfills/pull/28
[#36]: https://github.com/Yoast/PHPUnit-Polyfills/pull/36
[#38]: https://github.com/Yoast/PHPUnit-Polyfills/pull/38


## [0.2.0] - 2020-11-25

### Added
* `Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation`: a cross-version compatible base implementation for `TestListener`s using snake_case method names to replace the PHPUnit native method names.
* `Yoast\PHPUnitPolyfills\Helpers\AssertAttributeHelper` trait containing a `getProperty()` and a `getPropertyValue()` method.
    This is a stop-gap solution for the removal of the PHPUnit `assertAttribute*()` methods in PHPUnit 9.
    It is strongly recommended to refactor your tests/classes in a way that protected and private properties no longer be tested directly as they should be considered an implementation detail.
    However, if for some reason the value of protected or private properties still needs to be tested, this helper can be used to get access to their value.
* `Yoast\PHPUnitPolyfills\Polyfills\AssertNumericType` trait to polyfill the `Assert::assertFinite()`, `Assert::assertInfinite()` and `Assert::assertNan()` methods as introduced in PHPUnit 5.0.0.
* `Yoast\PHPUnitPolyfills\Polyfills\ExpectException` trait to polyfill the `TestCase::expectException()`, `TestCase::expectExceptionMessage()`, `TestCase::expectExceptionCode()` and `TestCase::expectExceptionMessageRegExp()` methods, as introduced in PHPUnit 5.2.0 to replace the `Testcase::setExpectedException()` and the `Testcase::setExpectedExceptionRegExp()` method.
* `Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory` trait to polyfill the `Assert::assertIsReadable()`, `Assert::assertIsWritable()` methods and their file/directory based variations, as introduced in PHPUnit 5.6.0.
* `Yoast\PHPUnitPolyfills\TestCases\TestCase`: support for the `assertPreConditions()` and `assertPostConditions()` methods.

### Changed
* The minimum supported PHP version has been lowered to PHP 5.5 (was 5.6).
* The minimum supported PHPUnit version has been lowered to PHP 4.8.36 (was 5.7).
    Note: for PHPUnit 4, only version 4.8.36 is supported, for PHPUnit 5, only PHPUnit >= 5.7.21 is supported.
* Readme: documentation improvements.


## [0.1.0] - 2020-10-26

Initial release.


[Unreleased]: https://github.com/Yoast/PHPUnit-Polyfills/compare/main...HEAD
[1.0.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/0.2.0...1.0.0
[0.2.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/e8f8b7a73737aa9a5974bd9c73d2bd8d09f69873...0.1.0

[Gary Jones]: https://github.com/GaryJones
[Marc Siegrist]: https://github.com/mergeMarc
[Mark Baker]: https://github.com/MarkBaker
