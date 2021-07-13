# User

Manages the currently authenticated account profile.

### Prepare
```php
$user = new Bitbucket\API\User();
$user->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get user profile: (API 2.0)

```php
$profile = $user->get();
```

### Retrieves the email for an authenticated user: (API 2.0)

```php
$user->emails();
```
----

#### Related:
  * [Authentication](authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/user+Endpoint#userEndpoint-Overview)
