Trip Service Kata
=================

Kata for legacy code hands-on session. The objective is to test and refactor the legacy TripService class.

The end result should be well-crafted code that express the domain.

You can [watch the video](https://www.youtube.com/watch?v=_NnElPO5BU0) with my solution. Although quite long, I explain my whole thought process while
writting tests, how I break dependencies, the reasons for refactoring and re-desining the code (tests and production code), and why certain steps are
important. I also cover how often I commit and why I do it.

The video is full of tips and tricks that can be used in any language.

## Business Rules

Imagine a social networking website for travellers:
- You need to be logged in to see the content
- You need to be a friend to see someone else's trips
- If you are not logged in, the code throws an exception


## Exercise Rules

- Our job is to write tests for the TripService class until we have 100% coverage
- Once we have 100% coverage, we need to refactor and make the code better.
- At the end of the refactoring, both tests and production code should clearly describe the business rules

## Exercise Constraints

- We cannot manually change production code if not covered by tests, that means:
    - We cannot type type of the TripService class while still not covered by tests
- If we need to change the TripService class in order to test, you can do so using automated refactorings (via IDE)
- We CANNOT change the public interface of TripService, that means:
    - We cannot change its constructor
    - We cannot change the method signature
    - Both changes above might cause other classes to change, which is not desirable now
- We CANNOT introduce state in the TripService
    - TripService is stateless. Introducing state may cause multi-thread issues

[Extracted rules from here](https://miro.com/app/board/uXjVOanLakQ=/)

# PHP

In order to perform the kata, first of all you will need to install all of the dependencies. This can be done using
composer (standing from the *"php"* directory")
```shell
wget http://getcomposer.org/composer.phar
php composer.phar install
```

Next, to execute the unit tests you need run this from the *php* directory
```shell
php bin/phpunit
```

## Coverage

When running the tests a coverage report should be generated automatically in simple text format and html report. If you want
to visualize it from the browser you can open the `coverage/report/index.html` file in a browser after running the tests.

Enjoy
