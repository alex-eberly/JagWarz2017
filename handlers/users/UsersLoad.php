<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$txtSearchUsername = "";
$txtSearchFirstname = "";
$txtSearchLastname = "";
if (isset($_POST["txtSearchUsername"])) 
{
	$txtSearchUsername = $_POST["txtSearchUsername"];
}
if (isset($_POST["txtSearchFirstname"])) 
{
	$txtSearchFirstname = $_POST["txtSearchFirstname"];
}
if (isset($_POST["txtSearchLastname"])) 
{
	$txtSearchLastname = $_POST["txtSearchLastname"];
}
$filter = "";
if ($txtSearchUsername != "")
{
	if ($filter != "") 
	{
		$filter .= ' and ';
	}
	$filter .= " Username like '%" . escapeString($txtSearchUsername) . "%' ";
}
if ($txtSearchFirstname != "")
{
	if ($filter != "") 
	{
		$filter .= ' and ';
	}
	$filter .= " Firstname like '%" . escapeString($txtSearchFirstname) . "%' ";
}
if ($txtSearchLastname != "")
{
	if ($filter != "") 
	{
		$filter .= ' and ';
	}
	$filter .= " Lastname like '%" . escapeString($txtSearchLastname) . "%' ";
}
if ($filter != "") 
{
	$filter .= ' and ';
}
$filter = ' where ' . $filter . ' Active = 1 ';
$UserFactory = new UserFactory();
$UserArray = $UserFactory->GetAll($filter);
if (count($UserArray) > 0)
{ 
	foreach ($UserArray as &$value)
	{
		echo '<tr>';
		echo '<td>';
		echo $value->Username;
		echo '</td>';
		echo '<td>';
		echo $value->Lastname;
		echo '</td>';
		echo '<td>';
		echo $value->Firstname;
		echo '</td>';
		echo '<td>';
		echo $value->Email;
		echo '</td>';
		echo '<td>';
		echo '<a href="javascript:void(0);" onclick="ajaxLoadUser(' . $value->UserId . ');ShowEdit();" class="pencil"></a> ';
		echo '<a href="javascript:void(0);" onclick="if(!confirm(\'Are you sure you want delete this item?\')) return false;ajaxDeleteItem(' . $value->UserId . ');" class="trash"></a>';
		echo '</td>';
		echo '</tr>';
	}
}
?>