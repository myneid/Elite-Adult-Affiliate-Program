<?php
//wm_track.php
//this will track the webmasterreferral hit and set a cookie

//i guess pass in id

//change this to wherever you want the link to go
$url = 'http://www.xxx.com/affiliate/webmaster_signup.php';

SetCookie('referred_webmaster_id',$_REQUEST['id'],time() + 84600,"/");

header("Location: $url?id=" . $_REQUEST['id']);

