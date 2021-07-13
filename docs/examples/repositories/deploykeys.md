# Deploykeys

Manage ssh keys used for deploying product builds.

### Prepare:
```php
$dk = new Bitbucket\API\Repositories\Deploykeys();
$dk->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of keys: (API 2.0)

```php
$dk->all($account_name, $repo_slug);
```

### Get a key content: (API 2.0)

```php
$dk->get($account_name, $repo_slug, 508372);
```

### Add a new key: (API 2.0)

```php
$dk->create($account_name, $repo_slug, 'ssh-rsa [...]', 'test key');
```

### Update an existing key: (API 2.0)

```php
$dk->update($account_name, $repo_slug, '508380', array('label' => 'test [edited]'));
```

### Delete an existing key: (API 2.0)

```php
$dk->delete($account_name, $repo_slug, '508380');
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/deploy-keys+Resource#deploy-keysResource-Overview)
