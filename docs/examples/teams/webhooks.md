# WebHooks

This resource manages webhooks on a team. The administrators of the team are 
the only users who can create, access, update, or delete the webhook.

### Prepare:
```php
$uuid	= '30b60aee-9cdf-407d-901c-2de106ee0c9d'; // unique identifier of the webhook
```

```php
$hooks = new Bitbucket\API\Teams\Hooks();
$hooks->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Get a webhook: (API 2.0)

```php
$hooks->get($account_name, $uuid);
```

**HINT:** You can use `$hooks->all()` method to get a list of all available hooks and their unique identifiers.

### Get a list of webhooks: (API 2.0)

```php
$hooks->all($account_name);
```

### Create a new webhook: (API 2.0)

```php
$hook->create($account_name, array(
    'description' => 'Webhook Description',
    'url' => 'http://requestb.in/xxx',
    'active' => true,
    'events' => array(
        'repo:push',
        'issue:created',
        'issue:updated'
    )
));
```

**HINT:** For a full list of available events, see [Hooks API documentation](https://developer.atlassian.com/bitbucket/api/2/reference/resource/teams/%7Busername%7D/hooks) page.

### Update a webhook: (API 2.0)

Add a new event `pullrequest:approved` to our webhook:

```php
$hook->update($account_name, $uuid, array(
    'description' => 'Webhook Description',
    'url' => 'http://requestb.in/xxx',
    'active' => true,
    'events' => array(
        'repo:push',
        'issue:created',
        'issue:updated',
        'pullrequest:approved'
    )
));
```

**HINT:** Bitbucket doesn't offer a patch endpoint, so you need to send the entire object represensation in order to update.

### Delete a webhook: (API 2.0)

```php
$hook->delete($account_name, $uuid);
```

----

#### Related:
  * [Authentication](../../examples/authentication.md)
  * [BB Wiki](https://developer.atlassian.com/cloud/bitbucket/rest/api-group-workspaces/#api-workspaces-workspace-hooks-post)
