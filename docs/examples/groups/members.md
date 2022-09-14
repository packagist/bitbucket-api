# Group members

Manage members of a group.

### Prepare:
```php
$group = new Bitbucket\API\Groups();
$group->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get the group members:
```php
$group->members()->all($account_name, $repo_slug);
```

### Add new member into a group:
```php
$group->members()->add($account_name, 'developers', 'steve');
```

### Delete a member from group:
```php
$group->members()->delete($account_name, 'developers', 'miriam');
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [Groups](../../examples/groups.md)
  * [Atlassian Documentation](https://support.atlassian.com/bitbucket-cloud/docs/groups-endpoint/)
