<?php

namespace Twisto;

function post_json($url, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($curl);

    if (curl_errno($curl))
    {
        throw new Error('Curl error: ' .curl_error($curl));
    }

    $info = curl_getinfo($curl);
    if ($info['http_code'] != 200)
    {
        throw new Error('API responded with wrong status code ('.$info['http_code'].')', json_decode($response));
    }

    $json = json_decode($response);
    if ($json == null)
    {
        throw new Error('API responded with invalid JSON');
    }

    return $json;
}