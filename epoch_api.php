<?php

$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, 'https://cardano-mainnet.blockfrost.io/api/v0/epochs/latest');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
    'project_id: mainnetxQR40X658ewaBjerixHJgI3OBfTvJ37R'
));
//project_id: mainnetxQR40X658ewaBjerixHJgI3OBfTvJ37R//
$response = curl_exec($cURLConnection);
curl_close($cURLConnection);

$json = json_decode($response);
//var_export($json);


// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->select_db("thecaun2_cardanoprojects");

if ($stmt = $conn->prepare("UPDATE cardano_metadata SET epoch = ?, start_time = ?, end_time = ? WHERE id = 1")){
    $stmt->bind_param('iii', $json->epoch, $json->start_time, $json->end_time);
   

    $stmt->execute();
    $stmt->close();
    echo "executed";
}
else {
//Error
echo "Prep statment failed: %s\n". $conn->error;
}