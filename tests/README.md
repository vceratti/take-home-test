# Tests

This project was developed using the PHPUnit framework in TDD style.
The testing code includes:

- Function testing: calling the public client.php with parameters, as an real use case, 
and checking expected results
- Unit testing: includes unit tests for all source code.

# Running the tests

If you have docker/docker-compose installed, you can simply run:

```bash
./ant test
```

This command will use containerized ant to run the test target and execute PHPUnit. 

```bash
./ant full
```

With the full build target, you can assure a report of code coverage is generated (build/output/phpunit).
