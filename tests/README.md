ABOUT THESE TESTS
=================

Part of the tests for this repo aren't unit tests or even integration tests as such. They are primarily _availability_ tests to be run against various combinations of PHP and PHPUnit to make sure this library polyfills the target functionality correctly.

Only for those polyfills which do more than point to another PHPUnit assertion, i.e. those which contain actual logic, the tests are more extensive.
