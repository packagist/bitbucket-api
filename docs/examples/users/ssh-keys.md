# Users ssh keys

Use the ssh-keys resource to manipulate the ssh-keys on an individual or team account.

### Prepare:
```php
$users = new Bitbucket\API\Users();
$users->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of the keys associated with an account: (API 2.0)

```php
$users->sshKeys()->all($account_name);
```

### Creates a key on the specified account: (API 2.0)

```php
$users->sshKeys()->create($account_name, 'key content', 'dummy key');
```

### Updates a key on the specified account: (API 2.0)

```php
$users->sshKeys()->update($account_name, 12, 'key content');
```

### Get the content of the specified `key_id`: (API 2.0)

```php
$users->sshKeys()->get($account_name, 12);
```

### Delete a ssh key: (API 2.0)

```php
$users->sshKeys()->delete($account_name, 12);
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [Users](../../examples/users.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-ssh/#api-group-ssh)
