<?php
	$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://secure.logmein.com/public-api/v1/authentication");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Accept: application/JSON; charset=utf-8";
$headers[] = "Authorization: {\"companyId\": 16843798, \"psk\": \"00_XBNKSPiAVgWSHXaDdSuUItUVDGxskqghBwhkH0TOnf7IDpTRbYTLjW5G11sS2mHZGkgZHPehjTLQ70vwcYdQUjqCIEhud7bKzil7QbfjXla2d5ZlHNSsaRhafW6pK\"}";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
//echo $result;

//https://secure.logmein.com/public-api/v2/hosts 
	$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://secure.logmein.com/public-api/v2/hosts");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Accept: application/JSON; charset=utf-8";
$headers[] = "Authorization: {\"companyId\": 16843798, \"psk\": \"00_XBNKSPiAVgWSHXaDdSuUItUVDGxskqghBwhkH0TOnf7IDpTRbYTLjW5G11sS2mHZGkgZHPehjTLQ70vwcYdQUjqCIEhud7bKzil7QbfjXla2d5ZlHNSsaRhafW6pK\"}";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

 //echo "<pre>";print_r(json_decode($result));ECHO "</pre>";

$h= json_decode($result);

$total=count($h->hosts);
echo "<table cellpadding=0 cellspacing=0 border =0>";
for ($i = 0; $i < $total; $i++) {
	   $desc = $h->hosts[$i]->description;
	   $sync=$h->hosts[$i]->hostStateChangeDate;
	   $online =$h->hosts[$i]->isHostOnline;
	   if(strpos($desc,'Team')!==false or strpos($desc,'Eliminar')!==false){
		
		$c=" style='display:none;' ";
			}else{$n++;
			$c="";}

		if($online==1){
			$on="<span style='color:#0c0; font-weight:bold; font-size:24px;'>&bull;</span>";
		}else{
			$on="<span style='color:#c00; font-weight:bold;font-size:24px;'>&bull;</span>";
		}
	   echo "\n<tr $c>\n\t<td >$on $n  ".$desc."</td>\n\t</tr>";
}
	
