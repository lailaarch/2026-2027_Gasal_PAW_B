<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";
echo 'fruits = ("' . implode('", "', $fruits) . '")<br>';
$terakhir = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$terakhir];
?>