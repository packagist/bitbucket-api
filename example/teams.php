<?php

require_once __DIR__.'/../vendor/autoload.php';

$teams = new Bitbucket\API\Teams();

// Your Bitbucket credentials
$bb_user = 'username';
$bb_pass = 'password';
$account = 'team-uuid';

// login
$teams->setCredentials( new Http\Message\Authentication\BasicAuth($bb_user, $bb_pass));

// Get all teams the user is admin in
// print_r($teams->all('admin')->getBody()->getContents());
// Get the profile for a single team
// print_r($teams->profile($account)->getBody()->getContents());
// Get all followers of a team
// print_r($teams->followers($account)->getBody()->getContents());
// Get the list of accounts this team is following
// print_r($teams->following($account)->getBody()->getContents());
// Get a list of members in a team
// print_r($teams->members($account)->getBody()->getContents());
// Get a list of repositories of a team
// print_r($teams->repositories($account)->getBody()->getContents());
