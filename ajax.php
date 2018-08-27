<?php
// hide errrors
error_reporting(0);


// Include connect file so we cann send data to database
include('connect.php');


///////////////////////////////////////
// Getting data for departure weather //
///////////////////////////////////////


// Get departure city
$departureCity= $_POST['departure'];


// Get cURL resource from api
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://maps.googleapis.com/maps/api/geocode/json?address='.$departureCity.'&sensor=true',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

$array = json_decode($resp,TRUE);

//Get lat and lng from city
$departureLat = $array['results']['0']['geometry']['location']['lat'];
$departureLng = $array['results']['0']['geometry']['location']['lng'];


$trenutniDatum = date('Y-m-d H:i:s');
$date = new DateTime(''.$trenutniDatum.'', new DateTimeZone('Europe/Sarajevo'));
//curent time
$curentDate = $date->format('Y-m-d\TH:00:00\Z');

// get data regarding departing cordiantes

$latitude =  mb_substr($departureLat, 0, 5);
$lontitude = mb_substr($departureLng, 0, 5);

$url = 'https://api.met.no/weatherapi/locationforecast/1.9/?lat='.$latitude.';lon='.$lontitude.'';
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

$data = curl_exec($ch); // execute curl request
curl_close($ch);


$xml = simplexml_load_string($data);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

$jsonFormat = json_encode($array, JSON_PRETTY_PRINT);



$productTime = $array['product']['time'];


// Getting graph by curent time
$trenutnoVrijeme = [];
$i = -1;

foreach($productTime as $productTimeParsed){
    $i ++;

    if($productTime[$i]['@attributes']['from'] == $curentDate){
    $trenutnoVrijeme[]= array(
        'from' => $productTime[$i]['@attributes']['from'],
        'dewPoint' => $productTime[$i]['location']['dewpointTemperature']['@attributes']['value'],
        'temperatura' => $productTime[$i]['location']['temperature']['@attributes']['value'],
        'vlaznost' => $productTime[$i]['location']['humidity']['@attributes']['value'],
        'fog' => $productTime[$i]['location']['fog']['@attributes']['percent'],
        'lowClouds' => $productTime[$i]['location']['lowClouds']['@attributes']['percent'],
        'mediumClouds' => $productTime[$i]['location']['mediumClouds']['@attributes']['percent'],
        'highClouds' => $productTime[$i]['location']['highClouds']['@attributes']['percent'],
    );
    }
    
}

// end of first graph by curent time


$dewPoint = $trenutnoVrijeme['0']['dewPoint'];
$temperatura = $trenutnoVrijeme['0']['temperatura'];
$vlaznost = $trenutnoVrijeme['0']['vlaznost'];
$fog = $trenutnoVrijeme['0']['fog'];
$lowClouds = $trenutnoVrijeme['0']['lowClouds'];
$mediumClouds = $trenutnoVrijeme['0']['mediumClouds'];
$highClouds = $trenutnoVrijeme['0']['highClouds'];

//transparency of fog area
if($fog <= 20){
    $transparencyOfFogImg = 'transparent_img0';
}else if($fog >=20 && $fog <= 50){
    $transparencyOfFogImg = 'transparent_img4';
}else {
    $transparencyOfFogImg = '';
}
//transparency of low cloud area
if($lowClouds <= 20){
    $transparencyOfLowImgCloud = 'transparent_img0';
}else if($lowClouds >=20 && $lowClouds <= 50){
    $transparencyOfLowImgCloud = 'transparent_img4';
}else {
    $transparencyOfLowImgCloud = '';
}

//transparency of medium cloud area
if($mediumClouds <= 20){
    $transparencyOfMediumImgCloud = 'transparent_img0';
}else if($mediumClouds >=20 && $mediumClouds <= 50){
    $transparencyOfMediumImgCloud = 'transparent_img4';
}else {
    $transparencyOfMediumImgCloud = '';
}
//transparency of high cloud area
if($highClouds <= 20){
    $transparencyOfHighImgCloud = 'transparent_img0';
}else if($highClouds >=20 && $highClouds <= 50){
    $transparencyOfHighImgCloud = 'transparent_img4';
}else {
    $transparencyOfHighImgCloud = '';
}





///////////////////////////////////////
// Getting data for destination weather //
///////////////////////////////////////


// Get destination city
$destinationCity= $_POST['destination'];


// Get cURL resource from api
$curlDestination = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curlDestination, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://maps.googleapis.com/maps/api/geocode/json?address='.$destinationCity.'&sensor=true',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$respDestination = curl_exec($curlDestination);
// Close request to clear up some resources
curl_close($curlDestination);

$arrayDestination = json_decode($respDestination,TRUE);

//Get lat and lng from city
$destinationLat = $arrayDestination['results']['0']['geometry']['location']['lat'];
$destinationLng = $arrayDestination['results']['0']['geometry']['location']['lng'];


$latitudeDestination =  mb_substr($destinationLat, 0, 5);
$lontitudeDestination = mb_substr($destinationLng, 0, 5);

$urlDestination = 'https://api.met.no/weatherapi/locationforecast/1.9/?lat='.$latitudeDestination.';lon='.$lontitudeDestination.'';
$chDestination = curl_init();
curl_setopt($chDestination, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chDestination, CURLOPT_URL, $urlDestination);    // get the url contents

$dataDestination = curl_exec($chDestination); // execute curl request
curl_close($chDestination);


$xmlDestination = simplexml_load_string($dataDestination);
$jsonDestination = json_encode($xmlDestination);
$arrayDestination = json_decode($jsonDestination,TRUE);

$jsonFormatDestination = json_encode($arrayDestination, JSON_PRETTY_PRINT);




$destinationTime = $arrayDestination['product']['time'];


// Getting second graph by curent time +1 
$trenutnoVrijemePlusOne = [];
$s = -1;

foreach($destinationTime as $destinationTimeParsedSecondTime){
    $s ++;

    if($destinationTime[$s]['@attributes']['from'] == $curentDate){
    $trenutnoVrijemePlusOne[]= array(
        'from' => $destinationTime[$s]['@attributes']['from'],
        'dewPoint' => $destinationTime[$s]['location']['dewpointTemperature']['@attributes']['value'],
        'temperatura' => $destinationTime[$s]['location']['temperature']['@attributes']['value'],
        'vlaznost' => $destinationTime[$s]['location']['humidity']['@attributes']['value'],
        'fog' => $destinationTime[$s]['location']['fog']['@attributes']['percent'],
        'lowClouds' => $destinationTime[$s]['location']['lowClouds']['@attributes']['percent'],
        'mediumClouds' => $destinationTime[$s]['location']['mediumClouds']['@attributes']['percent'],
        'highClouds' => $destinationTime[$s]['location']['highClouds']['@attributes']['percent'],
    );
    }
    
}

// end of first graph by curent time


$dewPointSecond = $trenutnoVrijemePlusOne['0']['dewPoint'];
$temperaturaSecond = $trenutnoVrijemePlusOne['0']['temperatura'];
$vlaznostSecond = $trenutnoVrijemePlusOne['0']['vlaznost'];
$fogSecond = $trenutnoVrijemePlusOne['0']['fog'];
$lowCloudsSecond = $trenutnoVrijemePlusOne['0']['lowClouds'];
$mediumCloudsSecond = $trenutnoVrijemePlusOne['0']['mediumClouds'];
$highCloudsSecond = $trenutnoVrijemePlusOne['0']['highClouds'];

//transparency of fog area
if($fogSecond <= 20){
    $transparencyOfFogImgSecond = 'transparent_img0';
}else if($fogSecond >=20 && $fogSecond <= 50){
    $transparencyOfFogImgSecond = 'transparent_img4';
}else {
    $transparencyOfFogImgSecond = '';
}
//transparency of low cloud area
if($lowCloudsSecond <= 20){
    $transparencyOfLowImgCloudSecond = 'transparent_img0';
}else if($lowCloudsSecond >=20 && $lowCloudsSecond <= 50){
    $transparencyOfLowImgCloudSecond = 'transparent_img4';
}else {
    $transparencyOfLowImgCloudSecond = '';
}

//transparency of medium cloud area
if($mediumCloudsSecond <= 20){
    $transparencyOfMediumImgCloudSecond = 'transparent_img0';
}else if($mediumCloudsSecond >=20 && $mediumCloudsSecond <= 50){
    $transparencyOfMediumImgCloudSecond = 'transparent_img4';
}else {
    $transparencyOfMediumImgCloudSecond = '';
}
//transparency of high cloud area
if($highCloudsSecond <= 20){
    $transparencyOfHighImgCloudSecond = 'transparent_img0';
}else if($highCloudsSecond >=20 && $highCloudsSecond <= 50){
    $transparencyOfHighImgCloudSecond = 'transparent_img4';
}else {
    $transparencyOfHighImgCloudSecond = '';
}

// import results in database

    $query = $db->prepare("
                    INSERT INTO log
                        (log_departure_city, log_departure_dew_point, log_departure_humidity, log_departure_temperature, log_departure_fog, log_departure_low_cloud, log_departure_medium_cloud, log_departure_high_cloud, log_destination_city, log_destination_dew_point, log_destination_humidity, log_destination_temperature, log_destination_fog, log_destination_low_cloud, log_destination_medium_cloud, log_destination_high_cloud, log_time)
                    VALUES
                        (:log_departure_city, :log_departure_dew_point, :log_departure_humidity, :log_departure_temperature, :log_departure_fog, :log_departure_low_cloud, :log_departure_medium_cloud, :log_departure_high_cloud, :log_destination_city, :log_destination_dew_point, :log_destination_humidity, :log_destination_temperature, :log_destination_fog, :log_destination_low_cloud, :log_destination_medium_cloud, :log_destination_high_cloud, :log_time)
    ");
    $query->execute(array(
                ':log_departure_city' => $departureCity,
                ':log_departure_dew_point' => $dewPoint,
                ':log_departure_humidity' => $vlaznost,
                ':log_departure_temperature' => $temperatura,
                ':log_departure_fog' => $fog,
                ':log_departure_low_cloud' => $lowClouds,
                ':log_departure_medium_cloud' => $mediumClouds,
                ':log_departure_high_cloud' => $highClouds,
                ':log_destination_city' => $destinationCity,
                ':log_destination_dew_point' => $dewPointSecond,
                ':log_destination_humidity' => $vlaznostSecond,
                ':log_destination_temperature' => $temperaturaSecond,
                ':log_destination_fog' => $fogSecond,
                ':log_destination_low_cloud' => $lowCloudsSecond,
                ':log_destination_medium_cloud' => $mediumCloudsSecond,
                ':log_destination_high_cloud' => $highCloudsSecond,
                ':log_time' => $curentDate
    ));


    /// Display results in front page
echo "
    <div class='row'>
    <div class='col-6'>
        <div class='row'>
            <div class='col-12 percent_area departure_area'>
                <h4>Departure weather</h4>

                <p><strong>Dew point: $dewPoint °</strong> </p> 
                <p><strong>Humidity: $vlaznost %</strong> </p>
                <p><strong>Temperature: $temperatura</strong></p> </br>
            </div>
        </div>
        <div class='row'>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$fog%</p>
                <p class='text-center reprezent_type'>Fog</p>
                <img class='sun_reprezentation' src='images/sun.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$lowClouds%</p>
                <p class='text-center reprezent_type'>Low <br>Clouds</p>
                <img class='cloud_reprezentation margin_low_cloud $transparencyOfLowImgCloud' src='images/cloud.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$mediumClouds%</p>
                <p class='text-center reprezent_type'>Medium <br>Clouds</p>
                <img class='cloud_reprezentation margin_medium_cloud $transparencyOfMediumImgCloud' src='images/cloud.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$highClouds%</p>
                <p class='text-center reprezent_type'>High <br>Clouds</p>
                <img class='cloud_reprezentation margin_high_cloud $transparencyOfHighImgCloud' src='images/cloud.png'>
            </div>
        </div>
    </div>
    <div class='col-6'>
        <div class='row'>
            <div class='col-12 percent_area'>
                <h4>Destination weather</h4>

                <p><strong>Dew point: $dewPointSecond °</strong> </p> 
                <p><strong>Humidity: $vlaznostSecond %</strong> </p>
                <p><strong>Temperature: $temperaturaSecond</strong></p> </br>
            </div>
        </div>
        <div class='row'>
            <div class='col-3 reprezent_area fog_area'>
                <p class='text-center reprezent_percent'>$fogSecond %</p>
                <p class='text-center reprezent_type'>Fog</p>
                <img class='sun_reprezentation' src='images/sun.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$lowCloudsSecond %</p>
                <p class='text-center reprezent_type'>Low <br>Clouds</p>
                <img class='cloud_reprezentation margin_low_cloud $transparencyOfLowImgCloudSecond' src='images/cloud.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent '>$mediumCloudsSecond %</p>
                <p class='text-center reprezent_type'>Medium <br>Clouds</p>
                <img class='cloud_reprezentation margin_medium_cloud $transparencyOfMediumImgCloudSecond' src='images/cloud.png'>
            </div>
            <div class='col-3 reprezent_area'>
                <p class='text-center reprezent_percent'>$highCloudsSecond %</p>
                <p class='text-center reprezent_type'>High <br>Clouds</p>
                <img class='cloud_reprezentation margin_high_cloud $transparencyOfHighImgCloudSecond' src='images/cloud.png'>
            </div>
        </div>
    </div>
    </div>
";
?>