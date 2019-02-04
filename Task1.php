
<?php
header('Content-Type: application/json'); // allow JSON_PRETTY_PRINT, must be before any ECHOs

/*
a program in PHP to convert a GeoJSON file
into an array and vice versa
*/


//Read in the content of the JSON file (in the same directory)
$json = file_get_contents('CalgarySchools.geojson');

//Now decode the JSON into an associative array
$myArr = json_decode($json, true);

// print out the array, nicely formatted 
echo "<hr>DECODED JSON:<hr>";
echo "<pre>" . print_r($myArr, true) . "</pre>"; 

//re-encode the arary as json 
$newJSON = json_encode($myArr, JSON_PRETTY_PRINT);

//print it out again, nicely formatted
echo "<hr>NEWLY RE-ENCODED JSON:<hr>";
echo "<pre>" . print_r($newJSON, true) . "</pre>"; 

//write json to a file
//NOTE: had to run 'chmod 777 Lab2' in command line to allow write-permissions, where Lab2 is the name of this directory
$outputFile = 'results.geojson';
if(file_put_contents($outputFile, $newJSON)) {
    echo '<hr> Data successfully saved';
}
else {
    echo "error saving JSON file";
}


?>
