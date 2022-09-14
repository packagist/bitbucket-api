# Tags

Allows you to get a list of tags.

### Prepare:
```php
$tags = new Bitbucket\API\Repositories\Refs\Tags();
$tags->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a list of tags: (API 2.0)

```php
$tags->all($account_name, $repo_slug);
```

### Get an individual tag: (API 2.0)

```php
$tags->get($account_name, $repo_slug, $tag_name);
```

### Create a new tag: (API 2.0)

```php
$tags->create($account_name, $repo_slug, $tag_name, $hash);
```

----

#### Related:
  * [Authentication](../../../examples/authentication.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-refs/#api-repositories-workspace-repo-slug-refs-get)
