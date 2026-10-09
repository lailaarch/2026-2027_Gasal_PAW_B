<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
echo 'weight = (';
$first = true;
foreach($weight as $k => $v) {
    if (!$first) echo ', ';
    echo '"' . $k . '"=>"' . $v . '"';
    $first = false;
}
echo ')<br>';
echo "Data kedua: " . $weight["Barry"];
?>