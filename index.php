<?php
require('vendor/autoload.php');

use Virtualizor\Admin;

$key =  'i4jufxc9s987jyuatqjh1cs1t5u3xewx';
$pass = 'efuiunkf32r9znb1om3qz0f8or5giivz';
$ip = '94.102.51.104';

$admin = new Admin($ip, $key, $pass);

$post = array();
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
