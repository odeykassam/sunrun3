<?php
$submissionType = $_GET['op'];
header('Content-type: application/json');

if('phone'===$submissionType)
{
	echo json_encode(['code'=>200,'body'=>true]);
	die();

}
else if('location'===$submissionType && key_exists('postal',$_GET))
{
	zip();

}
else if('next'===$submissionType && key_exists('step',$_GET) && 'Q10'===$_GET['step'])
{
	echo json_encode(['code'=>200,'body'=>true]);
	die();
}
else
{
	echo json_encode(['code'=>200,'body'=>true]);
	die();
}
function zip()
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);

	$data = [
		"codes" => $_GET['postal'],
		"country"=>"US"
	];

	curl_setopt($ch, CURLOPT_URL, "https://app.zipcodebase.com/api/v1/search?" . http_build_query($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"apikey: 4008d3d0-6021-11ed-b12c-eb4a1fc4e092",
	));

	$response = curl_exec($ch);
	curl_close($ch);

	$json = json_decode($response);
	echo json_encode(['code'=>200,'body'=>json_encode($json->results->{$_GET['postal']})]);
	die();
}