<?php


print($_POST);

$PROJECT_ID = '5';
$TOKEN = 'token';

$request_xml = (isset($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
$xml = simplexml_load_string($request_xml); 
$revisionNumber = $xml->message;

$matches = array();
preg_match('/story\s*:\s*(\d*)/i', $xml->message, &$matches);

$storyId =  $matches[0];

$url = 'http://www.pivotaltracker.com/services/v3/projects/'.$PROJECT_ID.'/stories/'.$storyId.'/notes';
$xml = '<note><text>Commit: '.$xml->revision.'</text></note>';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','X-TrackerToken: '.$TOKEN));
curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml);

$response = curl_exec( $ch );

?>