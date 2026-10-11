<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// menambah lima data baru
$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

function tampilArray($nama, $arr) {
    $hasil = array();
    foreach ($arr as $k => $v) {
        $hasil[] = '"' . $k . '"=>"' . $v . '"';
    }
    echo $nama . " = (" . implode(", ", $hasil) . ")<br>";
}

tampilArray("height", $height);
echo "Nilai dengan indeks terakhir: " . end($height);
echo "<br><br>";

// hapus satu data tertentu (Barry)
unset($height["Barry"]);

tampilArray("height", $height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>
