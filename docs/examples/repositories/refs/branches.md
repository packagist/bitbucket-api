# Branches

Allows you to get a list of branches.

### Prepare:
```php
$branches = new Bitbucket\API\Repositories\Refs\Branches();
$branches->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of branches: (API 2.0)

```php
$branches->all($account_name, $repo_slug);
```

### Get an individual branch: (API 2.0)

```php
$branches->get($account_name, $repo_slug, $branch_name);
```

### Delete an individual branch: (API 2.0)

```php
$branches->delete($account_name, $repo_slug, $branch_name);
```

----

#### Related:
  * [Authentication](../../../examples/authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/src+Resources)
