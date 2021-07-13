# Authentication

Although you can access any public data without authentication, you need to authenticate before you can access certain features like
(_but not limited to_) accessing data from a private repository, or give access to a repository.
Bitbucket provides Basic and OAuth authentication.

### OAuth2 authorization

You can use `OAuth2Plugin` in order to make authorized requests using version 2 of OAuth protocol.

#### OAuth2 client credentials (_2-legged flow_)

  ```php
  // @see: https://bitbucket.org/account/user/<username or team>/api
  $oauth_params = array(
      'client_id'         => 'aaa',
      'client_secret'     => 'bbb'
  );

  $bitbucket = new \Bitbucket\API\Api();
  $bitbucket->addPlugin(
      new \Bitbucket\API\Http\Plugin\OAuth2Plugin($oauth_params)
  );

  $repositories = $bitbucket->api('Repositories');
  $response     = $repositories->all('my_account'); // should include private repositories
  ```

### OAuth1 authorization
This library comes with a `OAuthPlugin` which will sign all requests for you. All you need to do is to attach the plugin to
http client with oauth credentials before making a request.

#### OAuth1 1-legged
  ```php
  // OAuth 1-legged example
  // You can create a new consumer at: https://bitbucket.org/account/user/<username or team>/api
  $oauth_params = array(
      'oauth_consumer_key'      => 'aaa',
      'oauth_consumer_secret'   => 'bbb'
  );

  $user = new Bitbucket\API\User;
  $user->addPlugin(
      new \Bitbucket\API\Http\Plugin\OAuthPlugin($oauth_params)
  );

  // now you can access protected endpoints as consumer owner
  $response = $user->get();
  ```

### Basic authentication
To use basic authentication, you need to attach `BasicAuth` to the Api instance with your username and password.

_Please note that is not recommended from a security perspective to use your main account in automated tools and scripts
and you should really consider switching to [OAuth2](#oauth2-authorization) or [OAuth1](#oauth1-authorization)._

  ```php
  $user = new Bitbucket\API\User();
  $user->setCredentials(
      new \Http\Message\Authentication\BasicAuth($bb_user, $bb_pass)  
  );

  // now you can access protected endpoints as $bb_user
  $response = $user->get();
  ```

----

#### Related:
  * [Authentication @ BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/Use+the+Bitbucket+REST+APIs#UsetheBitbucketRESTAPIs-Authentication)
  * [OAuth on Bitbucket @ BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/OAuth+on+Bitbucket)
