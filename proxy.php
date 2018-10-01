<?php
//
//$ips = array("127.0.0.1:8002","127.0.0.1:8003","127.0.0.1:8004");
$ips = array("127.0.0.1:8002");


function healthCheck( $url ) {
    $timeout = 3;
    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
    $http_respond = curl_exec($ch);
    $http_respond = trim( strip_tags( $http_respond ) );
    $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
        return true;
    } else {
        // return $http_code;, possible too
        return false;
    }
    curl_close( $ch );
}
function curlGet($url){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

function curlPost($url, array $params)
{
    $postData = '';
    foreach($params as $k => $v)
    {
        $postData .= $k . '='.$v.'&';
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;

}

function run($ips){

    $key = array_rand($ips);
    $server  = $ips[$key];

    if (isset($_GET) && count($_GET) ) {
        echo curlGet($server.'/'.$_GET['route']);
    } elseif (isset($_POST) && count($_POST)) {
        echo curlPost($server.'/'.$_POST['route'],$_POST);
    }
}

//function _contracture($ips){
//    $key = array_rand($ips);
//    $server  = $ips[$key];
//    if( !healthCheck( $server ) ) {
//        unset($ips[$key]);
//        _contracture($ips);
//    }
//    else {
//        run($server);
//    }
//}

if(isset($_GET)|| isset($_POST)){
    run($ips);
}



