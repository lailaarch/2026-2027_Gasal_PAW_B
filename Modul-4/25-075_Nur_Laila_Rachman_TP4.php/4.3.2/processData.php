<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Register</title>
</head>
<body>
<h1>Register</h1>
<?php
$errors = array();

if (isset($_POST['surname']))
{
    require 'validate.inc';

    // Validasi form (langkah 5 + langkah 9: semua field)
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'passwd');
    validateAddress($errors, $_POST, 'address');
    validateState($errors, $_POST, 'state');
    validateGender($errors, $_POST, 'sex');

    if ($errors)
    {
        echo '<h2 class="error">Invalid, correct the following errors:</h2>';
        echo '<div class="error">';
        foreach ($errors as $field => $error)
            echo "$field $error</br>";
        echo '</div><br/>';

        // tampilkan kembali form (form.inc mengisi ulang data sebelumnya)
        include 'form.inc';
    }
    else
    {
        echo 'Form submitted successfully with no errors';
    }
}
else
{
    // tampilkan form kosong
    include 'form.inc';
}
?>
</body>
</html>
