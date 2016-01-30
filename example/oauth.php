<?php

require './example.php';

use Thenbsp\Wechat\Bridge\Util;
use Thenbsp\Wechat\OAuth\Client;
use Thenbsp\Wechat\OAuth\Exception\OAuthUserException;
use Thenbsp\Wechat\OAuth\Exception\AccessTokenException;

/**
 * 只能在微信中打开
 */
if ( Util::isWechat() ) {
    exit('请在微信中打开');
}

$client = new Client(APPID, APPSECRET);
// $client->setScope('snsapi_userinfo');
// $client->setRedirectUri('current url');

if( !isset($_GET['code']) ) {
    header('Location: '.$client->getAuthorizeUrl());
}

// 获取用户 AccessToken
try {
    $accessToken    = $client->getAccessToken($_GET['code']);
    $userinfo       = $client->getUserinfo();
} catch (AccessTokenException $e) {
    exit($e->getMessage());
} catch (OAuthUserException $e) {
    exit($e->getMessage());
}

echo '<pre>';
var_dump($accessToken->toArray());
var_dump($userinfo->toArray());
echo '</pre>';

