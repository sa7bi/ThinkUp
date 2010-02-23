<?php 
session_start();

// set up
chdir("..");
require_once('config.webapp.inc.php');
ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.$INCLUDE_PATH);
require_once("init.php");

if (!isset($_GET['usr']) || !isset($_GET['code']) ) 
	header("Location: login.php?emsg=Houston,+we+have+a+problem:+account+activation+failed.");

$db = new Database($THINKTANK_CFG);
$conn = $db->getConnection();
$od = new OwnerDAO($db);

$acode = $od->getActivationCode($_GET['usr']);

if ($_GET['code'] == $acode['activation_code']) {
    $od->updateActivate($_GET['usr']);
	header("Location: login.php?smsg=Success!+Your+account+has+been+activated.+You+may+sign+into+ThinkTank.");
} else {
	header("Location: login.php?emsg=Houston,+we+have+a+problem:+account+activation+failed.");
}

?>
