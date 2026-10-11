<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// menambah lima data baru
$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

$hasil = array();
foreach ($height as $k => $v) {
    $hasil[] = '"' . $k . '"=>"' . $v . '"';
}
echo "height = (" . implode(", ", $hasil) . ")<br><br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.";
    echo "<br>";
}
?>
