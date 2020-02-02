<?php

require_once __DIR__.'/../vendor/autoload.php';

$repositories = new Bitbucket\API\Repositories();

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';
$account = 'team-uuid';

// login
$repositories->setCredentials( new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));

// Get all repositories of a team or user
 print_r($repositories->all($account)->getBody()->getContents());
