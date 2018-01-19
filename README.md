# Take Home Test

This is a test project. It's complete definition is in [this file](docs/Take_Home_Test.pdf). 

# Assumptions

The following assumptions about the project were considered:

- The task is about making a CLI Client, so I'm not providing any server configuration (although the used container has 
a running instance of Apache). 
A Docker image for development is included so you can run the PHP Cli, Tests, build... 
I did not provide any "production configuration" as I think it's not the focus here.  

- The task says the script "should accept" the described arguments, which does'nt mean they are mandatory. 
However, I'm considering all of them mandatory for simplicity (KISS and YAGNI principles).

- There's no definition for behaviour in case of invalid parameters. I'm adding a JSON return in case of errors.

- Since the URL is a parameter, something with a huge return could be used to hang the application. 
I'm not handling this case.

- I did not make any complex Exception system. Only a simple exception is handled at the client.

- About the Product Entity: as the output sample showed a simple list of product_id => [ start times, ... ], 
I have considered that two entries for the same product_id and same start time represents the same item, considering
the duration of the first found, only.
 
# Requirements

This project was intended for using Docker containers under a Debian based Linux system (Ubuntu, Mint).

If you don't have Docker-CE or Docker Compose installed, you can run the [docker install script](install).
 
However, if you just want to run the script, 
you need to have PHP 7.1 and Composer installed - check [composer.json](composer.json). 
The test, composer and build scripts provided in the project are all based on the included [docker image](Dockerfile).

# Setup 

In order to make our app work, you need to run Composer install and any other dependency. 
The included install script will check for Docker and DockerCompose (and install them if you need), 
start the development container and run the Ant full build target. Just run:

```bash
./install
```

The first run of the install script can take a really long time, for compiling the Docker file and requiring 
composer packages.

If you have your own PHP 7.1 and Composer installation, just run:
```bash
composer install
``` 

# Usage

After installing all dependencies, you can run the CLI client in the public folder with:
```bash
cd public &&
./php client.php http://www.mocky.io/v2/58ff37f2110000070cf5ff16 2017-11-20T09:30 2017-11-20T19:30 3
```

If you have your own PHP install, please check version and dependencies. 

# Guide 

- For more details on the code, check [the source code README](/src/README.md)'.'
- For information about the tests, check [the test README](/tests/README.md).
- For details of all available Ant targets, check [the build README](/build/README.md). 
- For more details on using client and parameters, check [the public client README](/public/README.md).
- The Dockerfile used here is derived from this project:
[hub.docker.com/r/vceratti/php-build](https://hub.docker.com/r/vceratti/php-build).  
- [.idea](.idea) folder is included for the shareable project configurations for PHPStorm, which includes inspections,
styles, etc
- [.composer](.composer) folder is mapped to the container Composer cache. This mapping is for faster 
execution of composer installs / updates and can be removed.

### Maintainer  ###

Vinícius Ceratti

_v.ceratti@gmail.com_ |  _linkedin.com/in/vceratti_ | _Skype: ceratti_
