<?php

require '../src/PhpXirr.php';
use phpXirr\PhpXirr;

$data = [
    ['date' => '2017-04-30', 'payment' => '1000000'],
    ['date' => '2019-01-31', 'payment' => '1'],
];

$PhpXirr = new PhpXirr();
$PhpXirr->XirrData($data);
$interest = $PhpXirr->getXirr();
echo $interest; // 0.084870
exit;
