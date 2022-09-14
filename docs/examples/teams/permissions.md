# Team permissions

Fetch permissions for members in a team.

### Prepare
```php
$permissions = new Bitbucket\API\Teams\Permissions();
$permissions->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get permissions for every member of a team: (API 2.0)

```php
$permissions->all($team_name);
```

### Get permissions for every member of every repository of a team: (API 2.0)

```php
$permissions->repositories($team_name);
```

### Get permissions for every member of one repository of a team: (API 2.0)

```php
$permissions->repositories($team_name, $repo);
```
----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-workspaces/#api-workspaces-workspace-permissions-get)
