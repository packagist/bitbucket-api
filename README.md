# PHP Bitbucket API

Bitbucket API wrapper for PHP

## Requirements

* PHP >= 7.1 with [cURL](http://php.net/manual/en/book.curl.php) extension.
* [Buzz](https://github.com/kriswallsmith/Buzz) library or any [HTTPlug](http://httplug.io/) compatible http client,
* PHPUnit to run tests. ( _optional_ )

## Install

Via Composer:

```bash
$ composer require private-packagist/bitbucket-api php-http/guzzle6-adapter
```

Why do you need to require `php-http/guzzle6-adapter`? We are decoupled from any HTTP messaging client with help by [HTTPlug](http://httplug.io/), so you can pick an HTTP client of your choice, guzzle is merely a recommendation.

## Documentation

See the [examples folder](docs/examples/index.md) for more detailed documentation.

## License

`bitbucket-api` is licensed under the MIT License - see the LICENSE file for details

## Acknowledgements

This package is a successor to the api client library [gentle/bitbucket-api](https://packagist.org/packages/gentle/bitbucket-api) by Alexandru Guzinschi.

## Contribute

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

For any security related issues, please send an email at [contact@packagist.com](contact@packagist.com) instead of using the issue tracker.

