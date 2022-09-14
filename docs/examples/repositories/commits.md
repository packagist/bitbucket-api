# Commits

Retrieve and compare information about commits.

### Prepare:
```php
$commits = new Bitbucket\API\Repositories\Commits();
$commits->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get all commits for a repository: (API 2.0)

```php
$commits->all($account_name, $repo_slug);
```

### Get all commits for a single branch: (API 2.0)

```php
$commits->all($account_name, $repo_slug, array(
    'branch' => 'master' // this can also be a tag
));
```

### Get an individual commit: (API 2.0)

```php
$commits->get($account_name, $repo_slug, $commitSHA1);
```

### Approve a commit: (API 2.0)

```php
$commits->approve($account_name, $repo_slug, $commitSHA1);
```

### Delete a commit approval: (API 2.0)

```php
$commits->deleteApproval($account_name, $repo_slug, $commitSHA1);
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [Commit(s) comments](./commits/comments.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-commits/#api-repositories-workspace-repo-slug-commits-get)
