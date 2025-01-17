# Branch restrictions

Manage branch restrictions on a repository

### Prepare:
```php
$restrictions = new Bitbucket\API\Repositories\BranchRestrictions();
$restrictions->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get the information associated with a repository's branch restrictions: (API 2.0)

```php
$restrictions->all($account_name, $repo_slug);
```

### Creates restrictions: (API 2.0)

Restrict push access to any branches starting with `joe-and-mary-` only to users `joe` and `mary`:

```php
$restrictions->create($account_name, $repo_slug, array(
    'kind'      => 'push',
    'pattern'   => 'joe-and-mary-*',
    'users'     => array(
        array('username' => 'joe'),
        array('username' => 'mary')
    )
));
```

### Get a specific restriction: (API 2.0)

```php
$restrictions->get($account_name, $repo_slug, $restrictionID);
```

### Update a specific restriction: (API 2.0)

```php
$restrictions->update($account_name, $repo_slug, $restrictionID, array(
    'users' => array(
        array('username' => 'joe'),
        array('username' => 'mary'),
        array('username' => 'joe-work')
    )
));
```

### Delete a specific restriction: (API 2.0)

```php
$restrictions->delete($account_name, $repo_slug, $restrictionID);
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-branch-restrictions/#api-repositories-workspace-repo-slug-branch-restrictions-get)
