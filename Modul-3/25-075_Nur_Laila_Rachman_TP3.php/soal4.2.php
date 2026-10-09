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
$keys = array("Andy", "Barry", "Charlie");
for($i = 0; $i < count($keys); $i++) {
    $k = $keys[$i];
    echo $k . " is " . $weight[$k] . " kg.<br>";
}
?>