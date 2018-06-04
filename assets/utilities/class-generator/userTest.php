<?php include 'users.gen.php' ?>
<?php
$usersFactory = new UsersFactory();
$user = $usersFactory->GetOne(2);
echo $user->Firstname . "<br />";
unset($user);
$usersArray = $usersFactory->GetAll(' where UserId = 2 ');
foreach ($usersArray as &$value)
{
	echo $value->Firstname . "<br />";
}
unset($value);
$u = new users();
$u->Username = "test2";
$u->Firstname = "testing";
$u->Lastname = "tester";
$usersFactory->Insert($u);
echo $u->UserId;

$u->Firstname = "tested";
$usersFactory->Update($u);
unset($u);
?>