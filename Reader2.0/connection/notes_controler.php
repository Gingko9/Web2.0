<?php
include ("db_connection.php");
header("Content-Type:text/plain");

if (isset($_REQUEST['flag']))
{
	$flag = $_REQUEST['flag'];
}
$result;
switch ($flag) {
	case 'number':
		$result = notes_Number();
		break;

	case 'create':
		$description = $_POST['description'];
		$title = $_POST['title'];
		$uid = (int)($_POST['uid']);
		$oid = (int)($_POST['oid']);
		$result = notes_Create($description,$title,$uid,$oid);
		break;
	
	case 'delete':
		$nid = (int)($_POST['nid']);
		$result = notes_Delete($nid);
		break;

	case 'update':
		$nid = (int)($_POST['nid']);
		$description = $_POST['description'];
		$title = $_POST['title'];
		$result = notes_Update($nid,$title,$description);
		break;

	default:
		break;
}
print_r($result);

function notes_Number()
{
	$mysql = Database::GetConnection();
	$query = "select count(*) as number from Notes";
	$temp = mysql_query($query);
	$array = mysql_fetch_array($temp);
	$result = $array['number'];
	
	Database::CloseConnection($mysql);
	return $result;
}

function notes_Create($description,$title,$uid,$oid)
{
	$since = date("Y-m-d H:i:s");
	$mysql = Database::GetConnection();
	$query = "insert into Notes values(NULL,'$description','$title',$uid,$oid,'$since')";
	$result = mysql_query($query);
	Database::CloseConnection($mysql);
	return $result;
}

function notes_Delete($nid)
{
	$mysql = Database::GetConnection();
	$query = "delete from Notes where nid=$nid";
	$result = mysql_query($query);
	Database::CloseConnection($mysql);
	return $result;
}

function notes_Update($nid,$title,$description)
{
	$since = date("Y-m-d H:i:s");
	$mysql = Database::GetConnection();
	$query = "update Notes set description='$description',title='$title',since='$since' where nid=$nid";
	$result  = mysql_query($query);
	Database::CloseConnection($mysql);
	return $result;
}

?>