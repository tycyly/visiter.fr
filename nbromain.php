<?php
$romain = "";
$nb = $donnees["siecle"];
while ($nb >= 10) {
	$romain = $romain . "X";
	$nb -= 10;
}

if ($nb <= 3) {
	while ($nb > 0) {
		$romain = $romain . "I";
		$nb -= 1;
	}

} else if ($nb == 4) {
	$romain = $romain . "IV";
	$nb = 0;

} else if ($nb <= 8) {
	$romain = $romain . "V";
	$nb -= 5;

	while ($nb > 0) {
		$romain = $romain . "I";
		$nb -= 1;
	}

} else {
	$romain = $romain . "IX";
	$nb = 0;
}

echo $romain;

echo "<sup>";
if ($romain == "I") {
	echo "er";
} else if ($romain == "II") {
	echo "nd";
} else {
	echo "e";
}
echo "</sup>";
?>