<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";
echo 'height = (';
$first = true;
foreach($height as $k => $v) {
    if (!$first) echo ', ';
    echo '"' . $k . '"=>"' . $v . '"';
    $first = false;
}
echo ')<br>';
foreach($height as $name => $val) {
    echo $name . " is " . $val . " cm tall.<br>";
}
?>