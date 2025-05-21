<?php
$a[] = "Rio de Janeiro";
$a[] = "North Bondi";
$a[] = "Berlin";
$a[] = "Rome";
$a[] = "Fuvahmulah";
$a[] = "Paris";
$a[] = "Tokyo";
$a[] = "Cape Town";
$a[] = "New York";
$a[] = "Barcelona";
$a[] = "Bangkok";
$a[] = "Dubai";
$a[] = "Istanbul";
$a[] = "Lisbon";
$a[] = "San Francisco";
$a[] = "Mumbai";
$a[] = "Delhi";
$a[] = "Bangalore";
$a[] = "Kolkata";
$a[] = "Chennai";
$a[] = "Goa";
$a[] = "Jaipur";
$a[] = "Agra";
$a[] = "Varanasi";
$a[] = "Kerala";
$a[] = "Udaipur";
$a[] = "Rishikesh";
$a[] = "Sydney";
$a[] = "Toronto";
$a[] = "Cairo";
$a[] = "Amsterdam";
$a[] = "London";
$a[] = "Prague";
$a[] = "Buenos Aires";
$a[] = "Hong Kong";


$q = $_REQUEST["q"];
$hint = "";

if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach($a as $destination) {
        if (stristr($q, substr($destination, 0, $len))) {
            if ($hint === "") {
                $hint = $destination;
            } else {
                $hint .= ", $destination";
            }
        }
    }
}

echo $hint === "" ? "no suggestion" : $hint;
?>
