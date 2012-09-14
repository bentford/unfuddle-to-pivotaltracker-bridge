<?php

$PROJECT_ID = '626107';
$TOKEN = '55fe2b03cbb9c0c17e8072b1a217c752';

$UNFUDDLE_SUBDOMAIN = 'theprogram';
$UNFUDDLE_REPO_ID = '90';

$request_xml = (isset($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
$xml = simplexml_load_string($request_xml); 


$matches = array();
preg_match('/story\s*:\s*(\d*)(.*)/i', $xml->message, $matches);

$storyId =  $matches[1];
$notes = $matches[2];

$url = 'http://www.pivotaltracker.com/services/v4/projects/'.$PROJECT_ID.'/stories/'.$storyId.'/comments';
$xml = '<comment><text>'."Commit Notes:\n".$notes."\n\nCommit URL:\nhttp://".$UNFUDDLE_SUBDOMAIN.'.unfuddle.com/a#/repositories/'.$UNFUDDLE_REPO_ID.'/commit?commit='.$xml->revision.'</text></comment>';

print 'posting to url: '.$url."\n";

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','X-TrackerToken: '.$TOKEN));
curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml);

$response = curl_exec( $ch );

?>