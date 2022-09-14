
# Commits comments

Manage commits comments.

### Prepare:
{% include auth.md var_name="commit" class_ns="Repositories\Commits" %}
```php
$commit = new Bitbucket\API\Repositories\Commits();
$commit->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of a commit comments: (API 2.0)

```php
$commit->comments()->all($account_name, $repo_slug, $commitSHA1)
```

### Get an individual commit comment: (API 2.0)

```php
$commit->comments()->get($account_name, $repo_slug, $commitSHA1, $commentID)
```

----

#### Related:
  * [Authentication](../../authentication.md)
  * [Commit(s)](../commits.md)
