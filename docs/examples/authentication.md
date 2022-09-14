# Authentication

Although you can access any public data without authentication, you need to authenticate before you can access certain features like
(_but not limited to_) accessing data from a private repository, or give access to a repository.
Bitbucket provides Basic and OAuth authentication.

### OAuth bearer authorization

To access the API with an OAuth access token, you need to attach `Bearer` to the Api instance with your access token.

  ```php
  $bitbucket = new \Bitbucket\API\Api();
  $bitbucket->setCredentials(
      new \Http\Message\Authentication\Bearer($accessToken)
  );

  $repositories = $bitbucket->api('Repositories');
  $response     = $repositories->all('my_account'); // should include private repositories
  ```

### Basic authentication
To use basic authentication, you need to attach `BasicAuth` to the Api instance with your username and a personal access token.

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
  * [Authentication on Bitbucket](https://developer.atlassian.com/cloud/bitbucket/rest/intro/#authentication)
