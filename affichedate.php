<?php
$split = explode(" ", $donnees['Date']);
$day = explode("-", $split[0]);
$time = explode(":", $split[1]);

if ($day[2] == "01") {
	echo "1<sup>er </sup> ";
} else {
	echo "{$day[2]} ";
}

if ($day[1] == "01") {
	echo "janvier ";

} else if ($day[1] == "02") {
	echo "février ";

} else if ($day[1] == "03") {
	echo "mars ";

} else if ($day[1] == "04") {
	echo "avril ";

} else if ($day[1] == "05") {
	echo "mai ";

} else if ($day[1] == "06") {
	echo "juin ";

} else if ($day[1] == "07") {
	echo "juillet ";

} else if ($day[1] == "08") {
	echo "août ";

} else if ($day[1] == "09") {
	echo "septembre ";

} else if ($day[1] == "10") {
	echo "octobre ";

} else if ($day[1] == "11") {
	echo "novembre ";

} else {
	echo "décembre ";
}
settype($time[0], int);
$time[0]=$time[0]+1;
echo $day[0]." ".$time[0]." h ".$time[1];
?>