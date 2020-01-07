---
layout: default
permalink: /examples/repositories/milestones.html
title: Issue milestones
---

# Issue milestones

Manage milestones on a issue tracker.

### Prepare:
{% include auth.md var_name="milestones" class_ns="Repositories\Milestones" %}

### Fetch all milestones:

```php
$milestones->all($accountname, $repo_slug);
```

### Fetch a single milestone:

```php
$milestones->get($accountname, $repo_slug, 56735);
```
----

#### Related:
  * [Authentication]({{ site.url }}/examples/authentication.html)
  * [BB Wiki](https://confluence.atlassian.com/display/BITBUCKET/issues+Resource#issuesResource-Overview)
