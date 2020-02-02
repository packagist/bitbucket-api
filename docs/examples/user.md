---
layout: default
permalink: /examples/user.html
title: User
---

# User

Manages the currently authenticated account profile.

### Prepare
{% include auth.md var_name="user" class_ns="User" %}

### Get user profile: (API 2.0)

```php
$profile = $user->get();
```

### Retrieves the email for an authenticated user: (API 2.0)

```php
$user->emails();
```
----

#### Related:
  * [Authentication]({{ site.url }}/examples/authentication.html)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/user+Endpoint#userEndpoint-Overview)
