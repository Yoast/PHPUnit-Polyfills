ABOUT THE END-TO-END TESTS
==========================

The end-to-end tests are specific to the TestListener Polyfill, which is hard to test in a PHPUnit cross-version compatible manner as the wiring under the hood in PHPUnit itself has changed too much.

By using end-to-end tests, we can still safeguard that the TestListener Polyfill works in the same way for all supported PHPUnit versions.

