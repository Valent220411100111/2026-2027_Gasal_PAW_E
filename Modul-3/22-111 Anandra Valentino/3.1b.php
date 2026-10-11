<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$hasil = array();
foreach ($weight as $k => $v) {
    $hasil[] = '"' . $k . '"=>"' . $v . '"';
}
echo "weight = (" . implode(", ", $hasil) . ")<br>";

// data kedua = indeks ke-1 dari daftar value
$nilai = array_values($weight);
echo "Data kedua: " . $nilai[1];
?>
