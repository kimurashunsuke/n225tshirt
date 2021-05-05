<?php
date_default_timezone_set('Asia/Tokyo');
define('BASE_DIR', '/var/www/html');
set_include_path(get_include_path() . PATH_SEPARATOR . BASE_DIR);

require_once 'DrawPng.php';
require_once 'UploadDropbox.php';

DrawPng::handle();
UploadDropbox::handle(BASE_DIR . '/export.png');

$script = file_get_contents(BASE_DIR . '/suzuri.side.base');
$script = str_replace('${date}', date('Y/m/d'), $script);
$fh = fopen(BASE_DIR . '/suzuri.side', 'w');
fwrite($fh, $script);
fclose($fh);
UploadDropbox::handle(BASE_DIR . '/suzuri.side');