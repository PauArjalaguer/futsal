
<?

Function stripAccents($String) {

    $String = preg_replace("[äáàâãª]", "a", $String);

    $String = preg_replace("[ÁÀÂÃÄ]", "A", $String);

    $String = preg_replace("[ÍÌÎÏ]", "I", $String);

    $String = preg_replace("[íìîï]", "i", $String);

    $String = preg_replace("[éèêë]", "e", $String);

    $String = preg_replace("[ÉÈÊË]", "E", $String);

    $String = preg_replace("[óòôõöº]", "o", $String);

    $String = preg_replace("[ÓÒÔÕÖ]", "O", $String);

    $String = preg_replace("[úùûü]", "u", $String);

    $String = preg_replace("[ÚÙÛÜ]", "U", $String);

    $String = preg_replace("[^´`¨~]", "", $String);

    $String = str_replace("ç", "c", $String);

    $String = str_replace("Ç", "C", $String);

    $String = str_replace("ñ", "n", $String);

    $String = str_replace("Ñ", "N", $String);

    $String = str_replace("Ý", "Y", $String);
    $String = str_replace("ý", "y", $String);
    return $String;
}

$address = stripAccents($_GET['complexAddress']);
echo "http://maps.google.com/maps/geo?q=" . $address . "&output=xml&sensor=false&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw <br />";
$xml = simplexml_load_file("http://maps.google.com/maps/geo?q=" . $address . "&output=xml&sensor=false&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw");
print_r($xml);
$coor = $xml->Response->Placemark->Point->coordinates;
$address=$xml->Response->

//echo $coor;
$c = explode(",", $coor);

$out .= "<div align=center style=''><div  id=\"map_canvas\" style=\"width: 500px; height: 300px; margin-bottom:10px;padding:3px; border:1px solid #ddd;\"></div></div>";
$out .= "\n\n<script src=\"http://maps.google.com/maps?file=api&v=2&key=ABQIAAAADKIrSO8QhdePb69IgQyNhRTAhSjkIBiGptVx9X9HprP3Oe5yPBS9Rp5ikn1ivqG2JoW8Gnyd-1jQAw&sensor=false\"
        type=\"text/javascript\"  charset=\"utf-8\"></script>
		\n<script type='text/javascript'>
		\t var map1 = new GMap2(document.getElementById(\"map_canvas\"));

		\t var point1 = new GLatLng(" . $c[1] . "," . $c[0] . ");
		\t map1.addOverlay(new GMarker(point1));

		\t var mapControl1 = new GMapTypeControl();
		\t map1.addControl(mapControl1);
		\t map1.addControl(new GLargeMapControl());

		\t map1.setCenter(new GLatLng(" . $c[1] . "," . $c[0] . "), 17);

		\n</script>\n\n";
echo $out;
