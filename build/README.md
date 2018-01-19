# Build

This folder contains the resources for several tools used for development. Those tools
can be executed by ant.

The build.xml is the Ant configuration file and includes individual targets, plus some complex targets for
building and CI. The main targets are:

- quick (default Ant target) - Runs composer-install, phpcs, phpmd, phpcpd, phpstan, phpunit without 
code-coverage report and checks if any of those targets failed

- full - run a full build including all of the quick targets, plus code coverage reports and phploc, phpmetrics and phpdoc.. 

- test - runs phpunit tests with no coverage report.

You can run any target by using [the ant executable script](../ant), in the project root:
```bash 
./ant full
```

# Syntax Check

The syntax checks targets are:

- phpcs - PHP CodeSniffer configured for PSR-2
- phpmd - PHP MessDetector plus phpmd-extension with several more rulesets; 
check the [phpmd configuration file](phpmd-ruleset.xml) for the checked rules
- phpcpd - PHP Copy Paste detector for DRY checking
- phpstan - Another syntax checks which also includes type checkings 

# Testing

Phpunit has two targets: 

- phpunit - for simply running the tests
- phpunit-no-coverage - d code coverage in html format, plus clover, crap4j and junit reports for CI.

# Reports

- phplocs - for simple summary of code size
- phpmetrics - for HTML project summary with code metrics
- phpdoc - for PHPDocumentor sumarry generation

# Ouput

You can check the build results in the [output folder](./output), wich is generated and updated after Ant execution.  





