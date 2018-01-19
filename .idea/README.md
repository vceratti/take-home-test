# Take Home Test

This is a test project. It's complete definition is in [this file](./docs/Take_Home_Test.pdf). 



# Assumptions

The following assumptions about the project were considered:

- The task is about making a CLI Client, so I'm not providing any server configuration. 
A Docker image for development is included so you can run the PHP Cli, Tests, build, etc. 
I did not provide any "production configuration" as I think it's not the focus here.  

- The task says the script "should accept" the described arguments, which does'nt mean they are mandatory. 
However, I'm considering all of them mandatory for simplicity (KISS principle).

- There's no definition for behaviour in case of invalid parameters. I'm adding a JSON return in case of errors.

- Since the URL is a parameter, something with a huge return could be used to hang the application. 
I'm adding validations and a configurable timeout for the request. 

# Requirements

This project was intended for using Docker containers under a Debian based Linux system (Ubuntu, Mint, etc...).

If you don't have Docker-CE or Docker Compose installed, you can run the [docker install script](./install).
 
However, if you just want to run the script, you need to have PHP 7.1 and Composer installed. 
The test, composer and build scripts provided in the project are all based on the included [docker image](./Dockerfile).


# Setup 

In order to make our app work, you need to run Composer install and any other dependency. 
The included install script will start the development container and run the ant install target. Just run:

```bash
./install
```

The first run of the install script can take a really long time, for compiling the Docker file and requiring 
composer packages, so be patience.

If you have your own PHP and Composer installation, just run:
```bash
composer install
``` 

# Usage

After installing all dependencies, you can run the CLI client with:
```bash
./php​ client.php http://www.mocky.io/v2/58ff37f2110000070cf5ff16 2017-11-20T09:30 2017-11-23T19:30​ 3
```

If you have your own PHP install, please check version and dependencies. 

For more details on the code and client parameters, check [the source code README](./src/README.md).

For information about the tests, check [the test README](./test/README.md).

For details of all available Ant targets, check [the build README](./build/README.md). 
 
For more details on the code and client parameters, check [the source code README](./src/README.md).

If you are not familiar with Docker, you can get the docs at 
[hub.docker.com/r/vceratti/php-build](https://hub.docker.com/r/vceratti/php-build). 
The Dockerfile used here is derived from this project.
 
 
@TODO behat e php spec
@TODO build e targets
@TODO bootstrap, autoloader, rest client, parameter sanitizer
@TODO test parameters
@TODO test api return   
@TODO timeout
@TODO make load test

### Mantainer  ###

Vinícius Ceratti

_v.ceratti@gmail.com_ |  _linkedin.com/in/vceratti_ | _Skype: ceratti_
