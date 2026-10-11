<?php
// 1.1 Menambah lima data baru, tampilkan nilai dengan indeks tertinggi
$fruits = array("Avocado", "Blueberry", "Cherry");

// tambah lima data baru
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo 'fruits = ( "' . implode('", "', $fruits) . '")<br>';

// nilai dengan indeks tertinggi
$indeksTertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];
?>
