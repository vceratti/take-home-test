# The source code

This project was building using PHP 7.1 version with strict typing. 

The [bootsrap file](bootstrap.php) is responsible for any configuration and composer autoloading.

The code is organized using a DDD-like design. The Application namespace includes the console client, while the
Domain namespace includes our entities.

# Code Rules

I have developed this project under an extensive list of rules, ensured by automated tools. Some of them are:

- Code style: PSR-2 for code style and PSR-4 for namespaces
- Size constraints: maximum of 5 for method cyclomatic complexity and 19 lines, max of 4 parameters, and more
- Naming constraints: no short variables (except for $id) and descriptive members names (3 words min for test names),
    no generic naming for classes or methods (Data, Manager, Information, etc...)
- Clean Code: no 'else', no boolean parameters, no static access, no ternaries, consistent return points
no complex expressions on return no public attributes, no "new" on constructors (use DI instead), no unused code.
- DRY: strictest possible configuration for detecting code duplicates
- TDD: developed with test driven approach, 100% of coverage was achieved.

Please, check [the build readme](../build/README.md) to check the tools used for the code rules, checks and testing.

# Dependencies

The only vendor library used in this project is the Guzzle HTTP client. 
I have chosen it to avoid manual 'curl' calls and have simplicity. Also, for a real project,
it would be a good choice for scaling, as it supports async, promises, etc.

# Domain\Product 

Our problem domain namespace includes:

``
- ProductEntity: the representation of a product and its properties
- ProductAggregate: a collection of products   
- ProductFilter: an entity+service object for filtering ProductEntities
- DateTime: a simple facade to the default \DateTime object with some utils.

The classes are not strict DDD standards. I have condensed some functionality to avoid
unneeded complexity and over-engineering. 
Some presentation functionality, like 'toJson' functions could be in the Application, for example.

# Application\Console

The Console Client is the only class on this namespace and it includes the outside world interface to the system 
- the console client.
A wrapper using this client is in [public/client](../public/README.md).
