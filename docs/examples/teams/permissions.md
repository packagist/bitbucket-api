---
layout: default
permalink: /examples/teams/permissions.html
title: Permissions
---

# Team permissions

Fetch permissions for members in a team.

### Prepare
{% include auth.md var_name="permissions" class_ns="TEams\Permissions" %}

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
  * [Authentication]({{ site.url }}/examples/authentication.html)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/user+Endpoint#userEndpoint-Overview)
