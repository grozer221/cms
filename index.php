<?php
include('config/config.php');
include ('core/Core.php');

$core = \core\Core::getInstance();
$core->init();
$core->run();
$core->done();