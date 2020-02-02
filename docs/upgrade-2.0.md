## UPGRADE FROM 1.x to 2.x

## Bitbucket API Deprecation
[Bitbucket deprecated their v1 API](https://developer.atlassian.com/cloud/bitbucket/deprecation-notice-v1-apis/) in 2019 and removed most of those endpoints already.
Additionally, they also removed several v2 API endpoints.

All the removed endpoints have been removed from this library.

### HTTP Plug
Instead of relying on [kriswallsmith/buzz](https://github.com/kriswallsmith/Buzz) this library can now be used with any [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible http client.
Also, have a look at [http://httplug.io/](http://httplug.io/) for more info.

#### Authentication
Authentication can be configured with the `AuthenticationPlugin` which is provided by the [php-http/client-common](https://github.com/php-http/client-common) library. Additionally, this library also provides `OAuthPlugin` and `OAuth2Plugin` plugins that come with the same functionality as the previous `OauthListener` and `Oauth2Listener` listeners.

Basic authentication can be configured like shown in the example below and more examples can be found on the [Authentication examples page](examples/authentication.html).
  ```php
  $user = new Bitbucket\API\User();
  $user->setCredentials(
      new \Http\Message\Authentication\BasicAuth($bb_user, $bb_pass)
  );

  // now you can access protected endpoints as $bb_user
  $response = $user->get();
  ```

#### Listener/Plugin
All listeners need to be adjusted to implement the `Http\Client\Common\Plugin` interface and can be registered like show in the example below.
```php
  $bitbucket = new \Bitbucket\API\Api();
  $bitbucket->addPlugin(
      new MyPlugin()
  );
```

#### Request/Response
PSR-7 uses a different request, and a different response object implementing the `\Psr\Http\Message\MessageInterface` interface. Access to both might require adjustments for several method calls. Most important: to access the response content instead of calling `$response->getContent()` one most now call `$response->getBody()->getContents()`.
