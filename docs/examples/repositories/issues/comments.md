# Issue comments

Manage issue comments.

### Prepare:
```php
$issue = new Bitbucket\API\Repositories\Issues();
$issue->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Fetch all comments: (API 2.0)

```php
$issue->comments()->all($accountname, $repo_slug, 4);
```

### Fetch a single comment: (API 2.0)

```php
$issue->comments()->get($accountname, $repo_slug, 4, 2967835);
```

### Add a new comment to specified issue: (API 2.0)

```php
$issue->comments()->create($accountname, $repo_slug, 4, 'dummy comment.');
```

### Update existing comment: (API 2.0)

```php
$issue->comments()->update($accountname, $repo_slug, 4, 3454384, "dummy comment [edited]");
```
----

#### Related:
  * [Authentication](../../../examples/authentication.md)
  * [Repository issues](../../../examples/repositories/issues.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-issue-tracker/#api-repositories-workspace-repo-slug-issues-issue-id-comments-get)
