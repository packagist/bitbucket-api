# Users

Get information related to an individual or team account.

### Prepare:
```php
$user = new Bitbucket\API\Users();
$user->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get the public information associated with a user: (API 2.0)

```php
$user->get($username);
```

### Get the list of the user's repositories: (API 2.0)

```php
$user->repositories($username);
```
----

#### Related:
  * [Authentication](authentication.md)
  * [Users invitations](users/invitations.md)
  * [Users ssh keys](users/ssh-keys.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/users+Endpoint)
