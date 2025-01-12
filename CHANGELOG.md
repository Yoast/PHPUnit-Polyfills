# Change Log for Yoast PHPUnit Polyfills

All notable changes to this project will be documented in this file.

This projects adheres to [Keep a CHANGELOG](http://keepachangelog.com/) and uses [Semantic Versioning](https://semver.org/).


## [Unreleased]

_Nothing yet._

## [3.1.2] - 2025-02-09

This is a maintenance release.

### Changed
* README: updated sub-section about PHPUnit version support with information about the PHPUnit Polyfills 4.x branch. PR [#249]
* General housekeeping.

<!-- Link to #249 is defined on the 1.1.4 release. -->


## [3.1.1] - 2025-01-12

### Fixed
* AssertContainsOnly::assertContainsNotOnlyInstancesOf(): incorrect parameter name. PR [#235]

### Changed
* General housekeeping.

[#235]: https://github.com/Yoast/PHPUnit-Polyfills/pull/235


## [3.1.0] - 2025-01-08

### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly` trait to polyfill the specialized `Assert::assertContains[Not]Only*()` methods as introduced in PHPUnit 11.5.0. PR [#225].

### Changed
* README: fix links which were broken due to an upstream branch removal. PR [#213].
* README: fixed a few broken badges.
* General housekeeping.

[#213]: https://github.com/Yoast/PHPUnit-Polyfills/pull/213
[#225]: https://github.com/Yoast/PHPUnit-Polyfills/pull/225


## [3.0.0] - 2024-09-07

### PHPUnit 11 support

This release updates the PHPUnit Polyfills to allow for _"writing your tests for PHPUnit 11 and running them all the way back to PHPUnit 6"_. \[*\]

Please keep in mind that the PHPUnit Polyfills provide _forward_-compatibility. This means that features which PHPUnit no longer supports in PHPUnit 11.x, are also no longer supported in the 3.0 release of the PHPUnit Polyfills.

Please refer to the [PHPUnit 11 release notification] and [PHPUnit 11 changelog] to inform your decision on whether or not to upgrade (yet).

Projects which don't use any of the new or removed functionality in their test suite, can, of course, use the PHPUnit Polyfills 1.x, 2.x and 3.x series side-by-side, like so `composer require --dev yoast/phpunit-polyfills:"^1.0 || ^2.0 || ^3.0"`.

[PHPUnit 11 release notification]: https://phpunit.de/announcements/phpunit-11.html
[PHPUnit 11 changelog]:            https://github.com/sebastianbergmann/phpunit/blob/11.0.10/ChangeLog-11.0.md

\[*\]: _Note: Releases from the PHPUnit Polyfills 3.x branch will support running tests on PHPUnit 6.4.4 - 9.x and 11.x, but will not allow for running tests on PHPUnit 10 (for reasons explained in [#200])._
_In practical terms, the net effect of this is that tests on PHP 8.1 will run on PHPUnit 9 instead of PHPUnit 10. Other than that, there is no impact._


### Changelog

#### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys` trait to polyfill the `Assert::assertArrayIsEqualToArrayOnlyConsideringListOfKeys()`, `Assert::assertArrayIsEqualToArrayIgnoringListOfKeys()`, `Assert::assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys()` and `Assert::assertArrayIsIdenticalToArrayIgnoringListOfKeys()` methods as introduced in PHPUnit 11.0.0. PR [#198].
* `Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation` trait to polyfill the `TestCase::expectUserDeprecationMessage()` and `TestCase::expectUserDeprecationMessageMatches()` methods as introduced in PHPUnit 11.0.0. PR [#200].
    These methods can largely be seen as replacements for the `TestCase::expectDeprecationMessage()` and `TestCase::expectDeprecationMessageMatches()` methods which were removed in PHPUnit 10.0, though there are significant differences between the implementation details of the old vs the new methods. Please see the [README for full details][readme-on-expectuserdeprecation].
* `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals` trait to polyfill the `Assert::assertObjectNotEquals()` method as introduced in PHPUnit 11.2.0. PR [#199].

#### Changed
* Composer: allow for installation of PHPUnit 11.x and removed runtime support for PHPUnit 10.x. PR [#196], [#200]
* The assertion failure message for the `assertIsList()` method has been updated to be in sync with the latest message format as used by PHPUnit 11.3.1+. [#195]
* The visibility of the `expectExceptionMessageMatches()` method has been changed from `public` to `protected`, in line with the same changes as per PHPUnit 11.0. [#197]
* The `assertObjectEquals()` method polyfill now behaves the same as the PHPUnit native assertion method. PR [#192]
    Previously a comparator method could either be compatible with PHP 5.6+ in combination with PHPUnit < 9.4.0 or with PHP 7.0+, but it wasn't possible to write a comparator method which would work in both situation due to the return type declaration requirement from PHPUnit itself. With the new PHP 7.0 minimum requirement, the return type declaration is now always required and the polyfill and the PHPUnit native method are completely aligned.
* General housekeeping.

#### Removed
* Support for PHP < 7.0. PR [#192].
* Support for PHPUnit < 6.4.4. PR [#193].
* The `Yoast\PHPUnitPolyfills\Helpers\AssertAttributeHelper` trait. PR [#194].
    This "helper" was only intended as a temporary measure to buy people some more time to refactor their tests.
* The `Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject` trait which is no longer needed now support for PHPUnit < 6.4 has been dropped. PR [#193].

[#192]: https://github.com/Yoast/PHPUnit-Polyfills/pull/192
[#193]: https://github.com/Yoast/PHPUnit-Polyfills/pull/193
[#194]: https://github.com/Yoast/PHPUnit-Polyfills/pull/194
[#195]: https://github.com/Yoast/PHPUnit-Polyfills/pull/195
[#196]: https://github.com/Yoast/PHPUnit-Polyfills/pull/196
[#197]: https://github.com/Yoast/PHPUnit-Polyfills/pull/197
[#198]: https://github.com/Yoast/PHPUnit-Polyfills/pull/198
[#199]: https://github.com/Yoast/PHPUnit-Polyfills/pull/199
[#200]: https://github.com/Yoast/PHPUnit-Polyfills/pull/200

[readme-on-expectuserdeprecation]: https://github.com/Yoast/PHPUnit-Polyfills/tree/3.x?tab=readme-ov-file#phpunit--1100-yoastphpunitpolyfillspolyfillsexpectuserdeprecation


## [2.0.4] - 2025-02-09

This is a maintenance release.

### Changed
* README: updated sub-section about PHPUnit version support with information about the PHPUnit Polyfills 4.x branch. PR [#249]
* General housekeeping.

<!-- Link to #249 is defined on the 1.1.4 release. -->


## [2.0.3] - 2025-01-08

This is a maintenance release.

### Changed
* README: fixed a few broken badges.
* General housekeeping.


## [2.0.2] - 2024-09-07

This is a maintenance release.

### Changed
* README: updated sub-section about PHPUnit version support with information about the PHPUnit Polyfills 3.x branch. PR [#188]
* README: FAQ updated with info about ability to polyfill the removed `expectDeprecation*()` methods et al. PR [#187], props [Tonya Mork].
* README: links to the PHPUnit manual now point explicitly to the PHPUnit 10.x documentation. PR [#190]
* General housekeeping.

[#187]: https://github.com/Yoast/PHPUnit-Polyfills/pull/187
<!-- Link to #188 is defined on the 1.1.2 release. -->
[#190]: https://github.com/Yoast/PHPUnit-Polyfills/pull/190


## [2.0.1] - 2024-04-05

### Added
* Compatibility fixes for running tests using a PHPUnit PHAR file for PHPUnit 8.5.38+, 9.6.19+ and PHPUnit 10.5.17+. PRs [#161], [#164].

### Changed
* General housekeeping.

[#164]: https://github.com/Yoast/PHPUnit-Polyfills/pull/164


## [2.0.0] - 2023-06-06

### PHPUnit 10 support

This release updates the PHPUnit Polyfills to allow for _"writing your tests for PHPUnit 10 and running them all the way back to PHPUnit 5"_.

Please keep in mind that the PHPUnit Polyfills provide _forward_-compatibility. This means that features which PHPUnit no longer supports in PHPUnit 10.x, like expecting PHP deprecation notices or warnings, are also no longer supported in the 2.0 release of the PHPUnit Polyfills.

Please refer to the [PHPUnit 10 release notification] and [PHPUnit 10 changelog] to inform your decision on whether or not to upgrade (yet).

Projects which don't use any of the new or removed functionality in their test suite, can, of course, use the PHPUnit Polyfills 1.x and 2.x series side-by-side, like so `composer require --dev yoast/phpunit-polyfills:"^1.0 || ^2.0"`.

[PHPUnit 10 release notification]: https://phpunit.de/announcements/phpunit-10.html
[PHPUnit 10 changelog]:            https://github.com/sebastianbergmann/phpunit/blob/10.0.19/ChangeLog-10.0.md

> :warning: **Important: about the TestListener polyfill** :warning:
>
> The TestListener polyfill in PHPUnit Polyfills 2.0 is **[not (yet) compatible with PHPUnit 10.0.0][polyfill-ticket]**.
>
> If you need the TestListener polyfill, it is recommended to stay on the PHPUnit Polyfills 1.x series for the time being and to watch the [related ticket][polyfill-ticket].

[polyfill-ticket]: https://github.com/Yoast/PHPUnit-Polyfills/issues/128


### Changelog

#### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings` trait to polyfill the `Assert::assertStringEqualsStringIgnoringLineEndings()` and the `Assert::assertStringContainsStringIgnoringLineEndings()` methods as introduced in PHPUnit 10.0.0. PR [#109].
* `Yoast\PHPUnitPolyfills\Polyfills\AssertIsList` trait to polyfill the `Assert::assertIsList()` method as introduced in PHPUnit 10.0.0. PR [#110].
* `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty` trait to polyfill the `Assert::assertObjectHasProperty()` and the `Assert::assertObjectNotHasProperty()` methods as introduced in PHPUnit 10.1.0. PR [#116].

#### Changed
* Composer: allow for installation of PHPUnit 10.x. PR [#130]
* Nearly all assertion methods are now `final`. This alignes them with the same change made upstream in PHPUnit 10.0.0. PR [#104].
* General housekeeping.

#### Removed
* Support for PHP < 5.6. PR [#102].
* Support for PHPUnit < 5.7.21. PR [#102].
* Support for expecting PHP deprecations, notices, warnings and error via the `Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException` trait. PR [#108].
    The trait has been removed completely as PHPUnit 10 no longer supports this functionality.
* The `Yoast\PHPUnitPolyfills\Polyfills\AssertNumericType` trait which is no longer needed now support for PHPUnit < 5.7 has been dropped. PR [#102].
* The `Yoast\PHPUnitPolyfills\Polyfills\ExpectException` trait which is no longer needed now support for PHPUnit < 5.7 has been dropped. PR [#102].
* The `Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory` trait which is no longer needed now support for PHPUnit < 5.7 has been dropped. PR [#102].

[#102]: https://github.com/Yoast/PHPUnit-Polyfills/pull/102
[#104]: https://github.com/Yoast/PHPUnit-Polyfills/pull/104
[#108]: https://github.com/Yoast/PHPUnit-Polyfills/pull/108
[#109]: https://github.com/Yoast/PHPUnit-Polyfills/pull/109
[#110]: https://github.com/Yoast/PHPUnit-Polyfills/pull/110
[#116]: https://github.com/Yoast/PHPUnit-Polyfills/pull/116
[#130]: https://github.com/Yoast/PHPUnit-Polyfills/pull/130


## [1.1.4] - 2025-02-09

This is a maintenance release.

### Changed
* README: updated sub-section about PHPUnit version support with information about the PHPUnit Polyfills 4.x branch. PR [#249]
* General housekeeping.

[#249]: https://github.com/Yoast/PHPUnit-Polyfills/pull/249


## [1.1.3] - 2025-01-08

This is a maintenance release.

### Changed
* README: fixed a few broken badges.
* General housekeeping.


## [1.1.2] - 2024-09-07

This is a maintenance release.

### Changed
* README: updated sub-section about PHPUnit version support with information about the PHPUnit Polyfills 3.x branch. PR [#188]
* General housekeeping.

[#188]: https://github.com/Yoast/PHPUnit-Polyfills/pull/188


## [1.1.1] - 2024-04-05

### Added
* Compatibility fix for running tests using a PHPUnit PHAR file for PHPUnit 8.5.38+ and PHPUnit 9.6.19+. PR [#161].

### Changed
* General housekeeping.

[#161]: https://github.com/Yoast/PHPUnit-Polyfills/pull/161


## [1.1.0] - 2023-08-19

### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty` trait to polyfill the `Assert::assertObjectHasProperty()` and `Assert::assertObjectNotHasProperty()` methods as backported from PHPUnit 10.1.0 to PHPUnit 9.6.11. PR [#135].

### Changed
* General housekeeping.

[#135]: https://github.com/Yoast/PHPUnit-Polyfills/pull/135


## [1.0.5] - 2023-03-31

### Fixed
* A custom `$message` parameter passed to an assertion, will no longer overrule an emulated "assertion failed" message, but will be prefixed to it instead. PR [#97].
    This applies to the following polyfills:
    - `assertIsClosedResource()`
    - `assertIsNotClosedResource()`
    - `assertIsReadable()`
    - `assertNotIsReadable()`
    - `assertIsWritable()`
    - `assertNotIsWritable()`
    - `assertDirectoryExists()`
    - `assertDirectoryNotExists()`
    - `assertStringNotContainsString()`
    - `assertStringNotContainsStringIgnoringCase()`

### Changed
* The `develop` branch has been removed. Development will now take place in the `1.x` and `2.x` branches.
* README: links to the PHPUnit manual now point explicitly to the PHPUnit 9.x documentation. PR [#94].
* README: new sub-section about PHPUnit version support. PR [#99].
* README: various minor improvements. PRs [#92], [#93].
* General housekeeping.

[#92]: https://github.com/Yoast/PHPUnit-Polyfills/pull/92
[#93]: https://github.com/Yoast/PHPUnit-Polyfills/pull/93
[#94]: https://github.com/Yoast/PHPUnit-Polyfills/pull/94
[#97]: https://github.com/Yoast/PHPUnit-Polyfills/pull/97
[#99]: https://github.com/Yoast/PHPUnit-Polyfills/pull/99


## [1.0.4] - 2022-11-16

This is a maintenance release.

### Changed
* The `Yoast\PHPUnitPolyfills\Autoload` class is now `final`. PR [#77].
* README: clear up minor language confusion. Props [Phil E. Taylor] and [fredericgboutin-yapla] for pointing it out.
* README: fix links which were broken due to an upstream branch rename. PR [#80].
* Verified PHP 8.2 compatibility.
* General housekeeping.

[#77]: https://github.com/Yoast/PHPUnit-Polyfills/pull/77
[#80]: https://github.com/Yoast/PHPUnit-Polyfills/pull/80


## [1.0.3] - 2021-11-23

### Changed
* General housekeeping.

### Fixed
* The failure message thrown for the `assertIsClosedResource()` and `assertIsNotClosedResource()` assertions will now be more informative, most notably, when the value under test _is_ a closed resource. PR [#65], props [Alain Schlesser] for reporting.

[#65]: https://github.com/Yoast/PHPUnit-Polyfills/pull/65


## [1.0.2] - 2021-10-03

As of version 2.15.0 of the `shivammathur/setup-php` action for GitHub Actions, the PHPUnit Polyfills can be installed directly from this action using the `tools` key.

### Added
* README: FAQ section about installing and using the library via the `shivammathur/setup-php` action. PR [#52].

### Changed
* README: minor textual clarifications and improvements. PRs [#52], [#54], props [Pierre Gordon].
* General housekeeping.

### Fixed
* Autoloader: improved compatibility with packages which create a `class_alias` for the `PHPUnit_Runner_Version` or `PHPUnit\Runner\Version` class. PR [#59].

[#52]: https://github.com/Yoast/PHPUnit-Polyfills/pull/52
[#54]: https://github.com/Yoast/PHPUnit-Polyfills/pull/54
[#59]: https://github.com/Yoast/PHPUnit-Polyfills/pull/59


## [1.0.1] - 2021-08-09

### Added
* The `Yoast\PHPUnitPolyfills\Autoload` class now contains a `VERSION` constant. Issue [#46], PR [#47], props [Pascal Birchler] for the suggestion.
    This version constant can be used by (complex) test setups to verify that the PHPUnit Polyfills which will be loaded, comply with the version requirements for the test suite.

### Changed
* Minor documentation updates. [#43]

[#43]: https://github.com/Yoast/PHPUnit-Polyfills/pull/43
[#46]: https://github.com/Yoast/PHPUnit-Polyfills/issues/46
[#47]: https://github.com/Yoast/PHPUnit-Polyfills/pull/47


## [1.0.0] - 2021-06-21

### Added
* `Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource` trait to polyfill the `Assert::assertIsClosedResource()` and `Assert::assertIsNotClosedResource()` methods as introduced in PHPUnit 9.3.0. PR [#27].
* `Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals` trait to polyfill the `Assert::assertObjectEquals()` method as introduced in PHPUnit 9.4.0. PR [#38].
    The behaviour of the polyfill closely matches the PHPUnit native implementation, but is not 100% the same.
    Most notably, the polyfill will check the type of the returned value from the comparator method instead of enforcing a return type declaration for the comparator method.
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
[3.1.2]: https://github.com/Yoast/PHPUnit-Polyfills/compare/3.1.1...3.1.2
[3.1.1]: https://github.com/Yoast/PHPUnit-Polyfills/compare/3.1.0...3.1.1
[3.1.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/2.0.4...3.0.0
[2.0.4]: https://github.com/Yoast/PHPUnit-Polyfills/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/Yoast/PHPUnit-Polyfills/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/Yoast/PHPUnit-Polyfills/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/Yoast/PHPUnit-Polyfills/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.1.4...2.0.0
[1.1.4]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.5...1.1.0
[1.0.5]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.4...1.0.5
[1.0.4]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/Yoast/PHPUnit-Polyfills/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/0.2.0...1.0.0
[0.2.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/Yoast/PHPUnit-Polyfills/compare/e8f8b7a73737aa9a5974bd9c73d2bd8d09f69873...0.1.0

[Alain Schlesser]: https://github.com/schlessera
[fredericgboutin-yapla]: https://github.com/fredericgboutin-yapla
[Gary Jones]: https://github.com/GaryJones
[Marc Siegrist]: https://github.com/mergeMarc
[Mark Baker]: https://github.com/MarkBaker
[Pascal Birchler]: https://github.com/swissspidy
[Phil E. Taylor]: https://github.com/PhilETaylor
[Pierre Gordon]: https://github.com/pierlon
[Tonya Mork]: https://github.com/hellofromtonya
