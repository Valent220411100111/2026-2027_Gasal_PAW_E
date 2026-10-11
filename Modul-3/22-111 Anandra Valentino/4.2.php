<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$hasil = array();
foreach ($weight as $k => $v) {
    $hasil[] = '"' . $k . '"=>"' . $v . '"';
}
echo "weight = (" . implode(", ", $hasil) . ")<br><br>";

// perulangan FOR pada array asosiatif: ambil key lebih dulu
$keys = array_keys($weight);
$n = count($weight);

for ($i = 0; $i < $n; $i++) {
    echo $keys[$i] . " is " . $weight[$keys[$i]] . " kg.";
    echo "<br>";
}
?>
