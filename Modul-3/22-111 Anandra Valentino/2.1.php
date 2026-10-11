<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

// menambah lima data baru dengan perulangan for
for ($i = 1; $i <= 5; $i++) {
    $fruits[] = "Buah Tambahan " . $i;
}

// panjang array dihitung SETELAH penambahan data
$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength;
echo "<br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}
?>
