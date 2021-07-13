<?php

require_once __DIR__.'/../../vendor/autoload.php';

$milestones = new Bitbucket\API\Repositories\Milestones;

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';

/**
 * $accountname The team or individual account owning the repository.
 * repo_slub    The repository identifier.
 */
$accountname    = 'company';
$repo_slug      = 'sandbox';


$milestones->setCredentials(new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));
# fetch all milestones
print_r($milestones->all($accountname, $repo_slug));

# fetch a single milestone
#print_r($milestones->get($accountname, $repo_slug, 56735));
