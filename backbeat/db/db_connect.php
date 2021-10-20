
<?php

// [ PRESETS ] 
$_PATH   = parse_ini_file(__DIR__ . '/../../backbeat.conf');
$_CONFIG = parse_ini_file(__DIR__ . "/../../{$_PATH['DB_CONF']}" . '/db.conf');
$_TYPE   = $_CONFIG['TYPE'];
$_HOST   = $_CONFIG['HOST'];
$_DB     = $_CONFIG['DB'];
$_USER   = $_CONFIG['USER'];
$_PASS   = $_CONFIG['PASS'];

// [ ESTABLISH > CONNECTION ]
$dsn = "$_TYPE:host=$_HOST;dbname=$_DB";
$_POST['pdo'] = new PDO($dsn, $_USER, $_PASS);