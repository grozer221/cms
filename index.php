<?php
include('config/config.php');
include ('core/Core.php');

$core = \core\Core::getInstance();
$core->init();
try{ $core->run();}
catch (Exception $e){
    header('Location: /notfound/');
}
$core->done();