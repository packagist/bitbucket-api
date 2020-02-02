<?php

require_once __DIR__.'/../vendor/autoload.php';

$users = new Bitbucket\API\Users;

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';
$account = 'account-uuid';

// login
$users->setCredentials( new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));

// Get a user's profile
// print_r($users->get($account)->getBody()->getContents());
// Get a user's repositories
// print_r($users->repositories($account)->getBody()->getContents());

// Get a user's invitations
// print_r($users->invitations()->all($account)->getBody()->getContents());

// Get a user's ssh keys
// print_r($users->sshKeys()->all($account)->getBody()->getContents());
