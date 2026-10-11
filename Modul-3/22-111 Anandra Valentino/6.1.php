<?php
// array_push()
$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";

// array_merge()
$a = array("A", "B");
$b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: " . implode(" ", array_merge($a, $b)) . "<br><br>";

// array_values()
$a = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: " . implode(" ", array_values($a)) . "<br><br>";

// array_search()
$a = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $a) . "<br><br>";

// array_filter() -> membuang nilai yang bernilai false/kosong (0, false, "")
$a = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: " . implode(" ", array_filter($a)) . "<br><br>";

// sort() dan rsort() pada array terindeks
$a = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($a);
echo "Hasil sort: " . implode(" ", $a) . "<br>";
rsort($a);
echo "Hasil rsort: " . implode(" ", $a) . "<br><br>";

// asort(), ksort(), arsort(), krsort() pada array asosiatif
function cetak($label, $arr) {
    echo $label . ": ";
    foreach ($arr as $k => $v) {
        echo $k . "=> " . $v . ", ";
    }
    echo "<br>";
}

$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$x = $age; asort($x);  cetak("Hasil asort", $x);
$x = $age; ksort($x);  cetak("Hasil ksort", $x);
$x = $age; arsort($x); cetak("Hasil arsort", $x);
$x = $age; krsort($x); cetak("Hasil krsort", $x);
?>
