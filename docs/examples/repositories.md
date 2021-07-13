# Repositories

The repositories namespace has a number of resources you can use to manage repository. The following resources are available on
repositories:

### Prepare:
```php
$repositories = new Bitbucket\API\Repositories();
$repositories->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of repositories for an account: (API 2.0)

If the caller is properly authenticated and authorized, this method returns a collection containing public and private repositories.

  ```php
  $repositories->all($account_name);
  ```

### Get a list of all public repositories: (API 2.0)

Only public repositories are returned.

  ```php
  $repositories->all();
  ```

----

#### Related:
  * [Authentication](authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/repositories+Endpoint)
