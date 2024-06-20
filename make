#!/usr/bin/php
<?php

require "vendor/autoload.php";
require 'app/core/Maker.php';
require  "config/config.php";

use app\core\Maker;

$command = $argv[1];
$argument = $argv[2];

(new Maker($command, $argument));


