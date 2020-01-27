I often create a boilerplate code for memory or redis cache classes. There is a pattern that is occurring repeatedly: 
* array of results containing loaded values
* wrapped repository/query class
* retrieval of existing value matching given specific function arguments
    * if value is found, it is returned immediately
    * otherwise the value is loaded from the wrapped class, assigned to the key in map and the value is returned from function     

This library is a POC for decreasing time required by developer on writing boilerplate code. Currently, this library 
focuses on generating PHP classes where most of the frameworks require additional configuration for services (Symfony)
or dependency injection (Magento 2). Another step after the code generation will be writing a library for configuration 
of these generated classes which will bind them to the interfaces they implement and provide wrapped class for caching 
as its constructor argument.
 
TODO:
Redis Cache template