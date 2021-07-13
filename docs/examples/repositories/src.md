# Source

Allows you to browse directories and view files, create branches and commit new files.

### Prepare:
```php
$src = new Bitbucket\API\Repositories\Src();
$src->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of the src in a repository.: (API 2.0)

```php
$src->get($account_name, $repo_slug, '1e10ffe', 'app/models/');
```

### Get raw content of an individual file: (API 2.0)

```php
$src->get($account_name, $repo_slug, '1e10ffe', 'app/models/core.php');
```

### Create file in repository: (API 2.0)

```php
$params = array();
$params['parent'] = 'master'; // Optional branch to commit to
$params['/path-to-file'] = 'File content'; // Can be multiple files per commit
$params['author'] = 'User <my@email.com>';
$params['message'] = 'Commit message';

$src->create($account_name, $repo_slug, $params);
```

### Delete file in repository: (API 2.0)

```php
$params = array();
$params['parent'] = 'master'; // Optional branch to commit to
$params['files'] = '/file-to-delete';
$params['author'] = 'User <my@email.com>';
$params['message'] = 'Commit message';

$src->create($account_name, $repo_slug, $params);
```

### Create new branch in repository: (API 2.0)

```php
$params = array();
$params['parent'] = 'master'; // Optional source branch
$params['branch'] = 'new-branch-name';
$params['author'] = 'User <my@email.com>';
$params['message'] = 'Commit message';

$src->create($account_name, $repo_slug, $params);
```
----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/src+Resources)
