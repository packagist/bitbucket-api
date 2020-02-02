---
layout: default
permalink: /examples/user/permissions.html
title: Permissions
---

# User

Fetch permissions for the currently authenticated account.

### Prepare
{% include auth.md var_name="permissions" class_ns="User\Permissions" %}

### Get a user's teams permissions: (API 2.0)

```php
$permissions->teams();
```

### Get a user's repositories permissions: (API 2.0)

```php
$permissions->repositories();
```
----

#### Related:
  * [Authentication]({{ site.url }}/examples/authentication.html)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/user+Endpoint#userEndpoint-Overview)
