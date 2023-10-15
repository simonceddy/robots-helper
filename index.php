<?php
require 'vendor/autoload.php';

$robots = \Eddy\Robots\Factory::make(file_get_contents(__DIR__ . '/robots.txt'));
dd($robots);
