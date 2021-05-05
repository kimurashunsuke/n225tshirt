<?php
define('BASE_DIR', '/var/www/html');
set_include_path(get_include_path() . PATH_SEPARATOR . BASE_DIR);

require_once 'DrawPng.php';
require_once 'UploadDropbox.php';

DrawPng::handle();
UploadDropbox::handle(BASE_DIR . '/export.png');