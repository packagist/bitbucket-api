# Invitations

Allows repository administrators to send email invitations to grant read, write, or admin privileges to a repository.

### Prepare:
```php
$invitation = new Bitbucket\API\Invitations();
$invitation->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
```

### Send invitation:

```php
$invitation->send($account_name, $repo_slug, 'user@example.com', 'read');
```

----

#### Related:
  * [Authentication](authentication.md)
  * [Atlassian Documentation](https://support.atlassian.com/bitbucket-cloud/docs/invitations-endpoint/)
