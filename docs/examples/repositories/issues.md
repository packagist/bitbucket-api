# Repository issues

Provides functionality for interacting with an issue tracker. Authentication is necesary to access private issue tracker,
to get more detailed information, to create and to update an issue.

### Prepare:
```php
$issue = new Bitbucket\API\Repositories\Issues();
$issue->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Fetch a list of issues: (API 2.0)

```php
$issue->all($account_name, $repo_slug);
```

### Fetch a single issue: (API 2.0)

```php
$issue->get($account_name, $repo_slug, 3);
```

### Fetch 5 issues that contains word `bug` in title: (API 2.0)

```php
$issue->all($account_name, $repo_slug, array(
    'limit' => 5,
    'start' => 0,
    'search' => 'bug'
));
```

### Add a new issue: (API 2.0)

```php
$issue->create($account_name, $repo_slug, array(
    'title'     => 'dummy title',
    'content'   => 'dummy content',
    'kind'      => 'proposal',
    'priority'  => 'blocker'
));
```

### Update an existing issue: (API 2.0)

```php
$issue->update($account_name, $repo_slug, 5, array(
    'title' => 'dummy title (edited)'
));
```

### Delete issue: (API 2.0)

```php
$issue->delete($account_name, $repo_slug, 5);
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [Issues comments](issues/comments.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-issue-tracker/#api-repositories-workspace-repo-slug-issues-get)
