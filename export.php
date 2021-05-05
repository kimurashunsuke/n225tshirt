<?php
require_once 'DrawPng.php';
require_once 'UploadDropbox.php';
DrawPng::handle();
UploadDropbox::handle('export.png');