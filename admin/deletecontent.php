<?php

require_once("../config.php");

$page_id = -1;
if (isset($_GET["page_id"])) {

	$page_id = $_GET["page_id"];

	$db = new DB($config);

	$query = "DELETE FROM pages where page_id = $page_id";
	$result = $db->query($query);
	$db->close();
}

redirect("listcontent.php");
