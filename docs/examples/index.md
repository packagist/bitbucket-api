# Usage examples

**TIP:** Although all examples from this documentation are instantiating each class, a single point of entry is also available:

  ```php
  $bitbucket = new \Bitbucket\API\Api();
  $bitbucket->setCredentials(new Http\Message\Authentication\BasicAuth('username', 'password'));

  /** @var \Bitbucket\API\User $user */
  $user = $bitbucket->api('User');

  /** @var \Bitbucket\API\Repositories\Issues $issues */
  $issues = $bitbucket->api('Repositories\Issues');
  ```

### Available examples

  - [Authentication](authentication.md)
  - [Group privileges](group-privileges.md)
  - [Groups](groups.md)
  - [Invitations](invitations.md)
  - [Privileges](privileges.md)
  - [Repositories](repositories.md)
    - [Branch restrictions](repositories/branch-restrictions.md)
    - [Commits](repositories/commits.md)
      - [Comments](repositories/commits/comments.md)
      - [Build statuses](repositories/commits/build-statuses.md)
    - [Deploy keys](repositories/deploy-keys.md)
    - [Issues](repositories/issues.md)
      - [Comments](repositories/issues/comments.md)
    - [Milestones](repositories/milestones.md)
    - [Pull requests](repositories/pull-requests.md)
      - [Comments](repositories/pull-requests/comments.md)
    - [Repository](repositories/repository.md)
    - [Refs](#)
      - [Branches](repositories/refs/branches.md)
      - [Tags](repositories/refs/tags.md)
    - [Hooks](repositories/webhooks.md)
    - [Src](repositories/src.md)
    - [Build statuses](repositories/commits/build-statuses.md)
  - [Teams](teams.md)
      - [Hooks](teams/webhooks.md)
      - [Permissions](teams/permissions.md)
  - [User](user.md)
    - [Permissions](user/permissions.md)
  - [Users](users.md)
    - [Invitations](users/invitations.md)
    - [SSH keys](users/ssh-keys.md)
