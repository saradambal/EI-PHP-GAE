<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 13/5/15
 * Time: 10:32 AM
 */
$event = new Google_Service_Calendar_Event();
//$event->setSummary('Appointment');
//$event->setLocation('Somewhere');

//$event->setSummary($summary);
//$event->setLocation($location);
$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime('2011-06-03T10:00:00.000-07:00');
$event->setStart($start);
$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime('2011-06-03T10:00:00.000-07:00');//2014-8-23T10:25:00.000+05:30
$event->setEnd($end);
//echo $summary;
echo 'before create';
$createdEvent = $cal->events->insert('itue2meb7ifu6123e1bs@group.calendar.google.com', $event); // to create a event
echo "Event Created <br> Event Id: " .$createdEvent->getId();

$drive = new Google_Client();
$drive->setClientId($ClientId);
$drive->setClientSecret($ClientSecret);
$drive->setRedirectUri($RedirectUri);
$drive->setScopes(array($DriveScopes,$CalenderScopes));
$drive->setAccessType('online');
$authUrl = $drive->createAuthUrl();
$refresh_token= $Refresh_Token;
$drive->refreshToken($refresh_token);
$cal = new Google_Service_Calendar($drive);

set_include_path( get_include_path() . PATH_SEPARATOR . 'google-api-php-client-master/src' );
require_once 'google/appengine/api/mail/Message.php';
require_once 'google-api-php-client-master/src/Google/Client.php';
require_once 'google-api-php-client-master/src/Google/Service/Drive.php';
include 'google-api-php-client-master/src/Google/Service/Calendar.php';