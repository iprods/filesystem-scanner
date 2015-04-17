<?php
require 'DirectoryScanner.php';
$scanner = new DirectoryScanner('.*?Test');
$scanner->scan([getcwd()]);
