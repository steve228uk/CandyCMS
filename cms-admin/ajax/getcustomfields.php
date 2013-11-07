<?

include '../classes/CustomFields.php';

echo CustomFields::getInput($_POST['key'], $_POST['name']);