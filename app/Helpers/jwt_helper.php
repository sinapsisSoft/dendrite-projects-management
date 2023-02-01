<?php 
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getSignedJWTForUser($id):string
{
    $issuedAtTime = time();
    $tokenTimeToLive = Services::getTimekey();
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'idUser' => $id,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(),'HS256');

    return $jwt;
}


function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    return $decodedToken->idUser;
    
}