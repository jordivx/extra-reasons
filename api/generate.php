<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");   

if (isset($_GET['user_input']) && $_GET['user_input']!="") {
	$user_input = $_GET['user_input'];

    $cohere_response = callCohereApi($user_input);

    $reasons = parseCohereResponse($cohere_response);

    storeSearchInDB($user_input, json_encode($reasons));
    
    header("HTTP/1.1 200 OK");
	echo json_encode($reasons);
}else{
    header("HTTP/1.1 400 Bad Request");
    exit();
}

function callCohereApi($user_input) {
    $cohere_data_raw = '{
        "model": "command-xlarge-nightly",
        "prompt": "This is a list of 5 sentences with developed reasons to '.$user_input.':",
        "max_tokens": 1012,
        "temperature": 0.9,
        "k": 0,
        "p": 0.75,
        "frequency_penalty": 0,
        "presence_penalty": 0,
        "stop_sequences": [],
        "return_likelihoods": "NONE"
    }';
    $cohere_api_key = getenv('COHERE_API_KEY');
    $cohere_headers = array('Authorization: '.$cohere_api_key,'Content-Type: application/json','Cohere-Version: 2022-12-06');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.cohere.ai/generate'); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $cohere_data_raw);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $cohere_headers);
    $cohere_response = curl_exec($ch);
    curl_close($ch);

    return $cohere_response;
}

function parseCohereResponse($cohere_response) {
    $cohere_parsed_response = json_decode($cohere_response, true);
    $response = str_replace("\n","",$cohere_parsed_response["generations"][0]["text"]);
    $reasons = preg_split("/(\d.\s)/", $response, -1, PREG_SPLIT_NO_EMPTY);
    return $reasons;
}

function storeSearchInDB($user_input, $reasons) {
    $db_host = getenv('MYSQL_DB_HOST');
    $db_username = getenv('MYSQL_DB_USERNAME');
    $db_password = getenv('MYSQL_DB_PASSWORD');
    $db_name = getenv('MYSQL_DB_NAME');

    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
    $escaped_input = $mysqli->real_escape_string($user_input);
    $escaped_reasons = $mysqli->real_escape_string($reasons);
    $mysqli->query("INSERT INTO `searches` (`prompt`, `response`) VALUES ('$escaped_input', '$escaped_reasons');");
}
?>