# User

Fetch permissions for the currently authenticated account.

### Prepare
```php
$permissions = new Bitbucket\API\User\Permissions();
$permissions->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a user's teams permissions: (API 2.0)

```php
$permissions->teams();
```

### Get a user's repositories permissions: (API 2.0)

```php
$permissions->repositories();
```
----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/user+Endpoint#userEndpoint-Overview)
