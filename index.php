<?php
require('vendor/autoload.php');

use Virtualizor\Admin;

$key =  'key';
$pass = 'pass';
$ip = 'ip';

$admin = new Admin($ip, $key, $pass);

$post['serid'] = 0;
$post['virt'] = 'kvm';
$post['uid'] = 0;
$post['user_email'] = 'test@test.com';
$post['user_pass'] = 'test123';
$post['fname'] = '';
$post['lname'] = '';
$post['plid'] = 1;
$post['osid'] = 878;
$post['hostname'] = 'test12345.com';
$post['rootpass'] = 'test123';
$post['stid'] = 3;

$output = $admin->createVps($post);

print_r(json_encode($output));
