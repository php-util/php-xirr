<?php

require '../src/PhpXirr.php';
use phpXirr\PhpXirr;

$data = [
    ['date' => '2017-04-30', 'payment' => '-100000'],
    ['date' => '2017-04-30', 'payment' => '2800'],
    ['date' => '2017-05-31', 'payment' => '2400'],
    ['date' => '2017-06-30', 'payment' => '2400'],
    ['date' => '2017-07-31', 'payment' => '2400'],
    ['date' => '2017-08-31', 'payment' => '2400'],
    ['date' => '2017-09-30', 'payment' => '2400'],
    ['date' => '2017-10-31', 'payment' => '2400'],
    ['date' => '2017-11-30', 'payment' => '2400'],
    ['date' => '2017-12-31', 'payment' => '2400'],
    ['date' => '2018-01-31', 'payment' => '2400'],
    ['date' => '2018-02-28', 'payment' => '2400'],
    ['date' => '2018-03-31', 'payment' => '2400'],
    ['date' => '2018-04-30', 'payment' => '2400'],
    ['date' => '2018-05-31', 'payment' => '2400'],
    ['date' => '2018-06-30', 'payment' => '2400'],
    ['date' => '2018-07-31', 'payment' => '2400'],
    ['date' => '2018-08-31', 'payment' => '2400'],
    ['date' => '2018-09-30', 'payment' => '2400'],
    ['date' => '2018-10-31', 'payment' => '2400'],
    ['date' => '2018-11-30', 'payment' => '2400'],
    ['date' => '2018-12-31', 'payment' => '2400'],
    ['date' => '2019-01-31', 'payment' => '2400'],
    ['date' => '2019-02-28', 'payment' => '2400'],
    ['date' => '2019-03-31', 'payment' => '2400'],
    ['date' => '2019-04-30', 'payment' => '2400'],
    ['date' => '2019-05-31', 'payment' => '2400'],
    ['date' => '2019-06-30', 'payment' => '2400'],
    ['date' => '2019-07-31', 'payment' => '2400'],
    ['date' => '2019-08-31', 'payment' => '2400'],
    ['date' => '2019-09-30', 'payment' => '2400'],
    ['date' => '2019-10-31', 'payment' => '2400'],
    ['date' => '2019-11-30', 'payment' => '2400'],
    ['date' => '2019-12-31', 'payment' => '2400'],
    ['date' => '2020-01-31', 'payment' => '2400'],
    ['date' => '2020-02-29', 'payment' => '2400'],
    ['date' => '2020-03-31', 'payment' => '31200'],
];

$PhpXirr = new PhpXirr();
$PhpXirr->XirrData($data);
$interest = $PhpXirr->getXirr();
echo $interest; // 0.084870
exit;
