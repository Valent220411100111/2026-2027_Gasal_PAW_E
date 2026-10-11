<?php
// 1.2 Menghapus satu data tertentu, tampilkan nilai dengan indeks tertinggi
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

// hapus data "Blueberry" (indeks 1)
unset($fruits[1]);
echo "Data Blueberry dihapus.<br>";

echo 'fruits = ( "' . implode('", "', $fruits) . '")<br>';

// unset() tidak menyusun ulang indeks, jadi indeks tertinggi diambil dengan array_key_last()
$indeksTertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];
?>
