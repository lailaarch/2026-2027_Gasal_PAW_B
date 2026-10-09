<?php
$arr = array("A");
echo 'Array awal: ("A")<br>';
array_push($arr, "B");
echo 'Hasil array_push: ' . implode(" ", $arr) . '<br><br>';

$a1 = array("A", "B");
$a2 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$merged = array_merge($a1, $a2);
echo 'Hasil array_merge: ' . implode(" ", $merged) . '<br><br>';

$assoc = array("x"=>1, "y"=>2);
echo 'Array awal: ("x"=>1, "y"=>2)<br>';
$vals = array_values($assoc);
echo 'Hasil array_values: ' . implode(" ", $vals) . '<br><br>';

$search_arr = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search("B", $search_arr) . '<br><br>';

$filter_arr = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$filtered = array_filter($filter_arr);
echo 'Hasil array_filter: ' . implode(" ", $filtered) . '<br><br>';

$nums = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
$s = $nums;
sort($s);
echo 'Hasil sort: ' . implode(" ", $s) . '<br>';
$rs = $nums;
rsort($rs);
echo 'Hasil rsort: ' . implode(" ", $rs) . '<br><br>';

$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$a = $age;
asort($a);
echo 'Hasil asort: ';
foreach($a as $k => $v) { echo "$k=>$v, "; }
echo '<br>';

$k = $age;
ksort($k);
echo 'Hasil ksort: ';
foreach($k as $key => $v) { echo "$key=>$v, "; }
echo '<br>';

$ar = $age;
arsort($ar);
echo 'Hasil arsort: ';
foreach($ar as $key => $v) { echo "$key=>$v, "; }
echo '<br>';

$kr = $age;
krsort($kr);
echo 'Hasil krsort: ';
foreach($kr as $key => $v) { echo "$key=>$v, "; }
?>