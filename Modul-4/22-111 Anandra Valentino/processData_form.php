<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Register</title>
<style>
  body{font-family:Arial,sans-serif;margin:20px}
  fieldset{background:#ddf;width:440px;border:1px solid #66a}
  .field{margin:4px 0;display:flex;align-items:flex-start}
  .field label{width:130px;text-align:right;padding-right:8px}
  .err{color:#b00020;margin-left:6px;font-size:12px}
</style>
</head>
<body>
<h1>Register</h1>
<?php
$errors = array();
if (isset($_POST['surname']))
{
    require 'validate.inc';
    validateName($errors,     $_POST, 'surname');
    validateEmail($errors,    $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors,  $_POST, 'address');
    validateState($errors,    $_POST, 'state');
    validateCountry($errors,  $_POST, 'country');
    validateGender($errors,   $_POST, 'sex');
    if ($errors)
    {
        echo '<h2>Invalid, correct the following errors:</h2>';
        foreach ($errors as $field => $error)
            echo "$field $error<br/>";

        // tampilkan kembali form
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
    // tampilkan form kosong
    include 'form.inc';
?>
</body>
</html>
