<?php
include 'includes/session.php';
 require_once('includes/config.php');


	if (isset($_GET['id'])){
		$textureid = (int)$_GET['id'];
		$userid = $_SESSION['user_id'];

	$qry =  $conn->prepare("DELETE FROM images WHERE user_id = :userid AND id = :textureid ");
				$qry->bindValue(':userid', $userid);
				$qry->bindValue(':textureid', $textureid);
				$qry->execute();
				$qry->fetchAll();
	}
header('Location: index.php');

?>