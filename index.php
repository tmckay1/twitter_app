<?php
require_once("./inc/include.php");

$page = new \Twitter\Pages\Home\HomePage();
$debugger->debug($page);
$debugger->debug(array('h' => 6));

$page->drawContents();

?>

<script type="text/javascript">
	$(document).ready(function(){
		console.log("hello world");
	});
</script>