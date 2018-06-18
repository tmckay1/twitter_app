<?php
require_once("./inc/include.php");

//initialize home page
$page = new \Twitter\Pages\Home\HomePage();

//draw home page
$page->drawContents();
