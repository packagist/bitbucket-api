---
layout: default
permalink: /examples/users/emails.html
title: Users emails
---

# Users emails

An account can have one or more email addresses associated with it. Use this end point to list, change, or create an email address.

### Prepare:
{% include auth.md var_name="users" class_ns="Users" %}

### Get a list of user's email addresses:

```php
$users->emails()->all($account_name);
```

### Gets an individual email address associated with an account:

```php
$users->emails()->get($account_name, 'dummy@example.com');
```

----

#### Related:
  * [Authentication]({{ site.url }}/examples/authentication.html)
  * [Users]({{ site.url }}/examples/users.html)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/emails+Resource)
