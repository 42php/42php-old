<?php

if ($argc > 3) {
    $u = new User();
    $pwd = \Core\Text::random(10);
    $u->set('firstname', $argv[1]);
    $u->set('lastname', $argv[2]);
    $u->set('email', $argv[3]);
    $u->set('lang', \Core\Conf::get('lang'));
    $u->setPassword($pwd);
    $u->save();
    echo "Email    : {$argv[3]}\n";
    echo "Password : {$pwd}\n";
} else {
    echo "Usage: php cli.php users/create firstname lastname email@domain.tld\n";
}