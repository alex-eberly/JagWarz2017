<?php include 'class.php' ?>
<?php
/*$user = new User();
$user->userid = 1;
$user->firstname = "Mitch";
$user->lastname = "Lindle";

echo $user->firstname;
*/
/*
$userFactory = new UserFactory();
$user = $userFactory->GetOne(1);
echo $user->firstname;
*/
$userFactory = new UserFactory();
$userArray = $userFactory->GetAll();
foreach ($userArray as &$value)
{
	echo $value->firstname . "<br />";
}
unset($value);
?>