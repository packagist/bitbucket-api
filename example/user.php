<?php

require_once __DIR__.'/../vendor/autoload.php';

$user = new Bitbucket\API\User;

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';

// login
$user->setCredentials( new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));

# get user profile
#print_r($user->get()->getBody()->getContents());
# get user emails
#print_r($user->emails()->getBody()->getContents());
