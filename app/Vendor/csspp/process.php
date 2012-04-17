<?php
require('csspp.php');

$csspp = new CSSPP($_GET['file'], realpath(dirname(__FILE__) . '/../') . '/');
$csspp->setOption('minify', FALSE);

header('Content-Type: text/css');
echo $csspp;