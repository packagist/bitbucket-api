# Repository

Allows you to create a new repository or edit a specific one.

### Prepare:
```php
$repo = new Bitbucket\API\Repositories\Repository();
$repo->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get information associated with an individual repository: (API 2.0)

```php
$repo->get($account_name, $repo_slug);
```

### Create a new repository: (API 2.0)

```php
$repo->create($account_name, $repo_slug, array(
    'scm'               => 'git',
    'description'       => 'My super secret project.',
    'language'          => 'php',
    'is_private'        => true,
    'fork_policy'       => 'no_public_forks',
));
```

### Update an existing repository: (API 2.0)

```php
$repo->update($account_name, $repo_slug, array(
    'description'   => 'My super secret project !!!',
    'language'      => 'php',
    'is_private'    => true
));
```

### Delete a repository: (API 2.0)

```php
$repo->delete($account_name, $repo_slug);
```

### Get the list of accounts watching a repository: (API 2.0)

```php
$repo->watchers($account_name, $repo_slug);
```

### Get the list of repository forks: (API 2.0)

```php
$repo->forks($account_name, $repo_slug);
```

### Fork a repository: (API 2.0)

```php
$repo->fork($account_name, $repo_slug, $fork_slug, array(
    'is_private' => true
));
```

### Get a list of branches associated with a repository: (API 2.0)

```php
$repo->branches($account_name, $repo_slug);
```

### Get a list of tags: (API 2.0)

```php
$repo->tags($account_name, $repo_slug);
```

### Get the history of a file in a changeset: (API 2.0)

```php
$repo->filehistory($account_name, $repo_slug, '1bc8345', 'app/models/core.php')
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-repositories/#api-repositories-workspace-get)
