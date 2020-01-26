<?php
if ($note != "Aucune note") {
	$max = 5;
	while ($note >= 1) {
		echo "<i class=\"fas fa-star\"></i>";
		$note -= 1;
		$max -= 1;
	}

	while ($note >= 0.5) {
		echo "<i class=\"fas fa-star-half-alt\"></i>";
		$note -= 0.5;
		$max -= 1;
	}

	while ($max > 0) {
		echo "<i class=\"far fa-star\"></i>";
		$max -= 1;
	}
} else {
	echo "Aucune note";
}
?>