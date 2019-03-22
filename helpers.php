<?php

namespace Dimacros;

use GuzzleHttp;
use function GuzzleHttp\json_decode;

function generate_short_link($ticket_id, $order_key) 
{
    $security = wp_create_nonce("download_ticket_{$ticket_id}_{$order_key}");

    $ticket_download_url = home_url('/') . '?' . http_build_query([
        'download_ticket' => $ticket_id,
        'order_key' => $order_key,
        'download_ticket_nonce' => $security
    ]);

    $client = new GuzzleHttp\Client();
    
    $response = $client->post('https://api-ssl.bitly.com/v4/shorten', [
        'headers' => [
            'Authorization' => 'Bearer ' . BITLY_ACCESS_TOKEN,
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ],
        'json' => [
            'group_guid' => BITLY_GROUP_GUID,
            'domain' => 'bit.ly',
            'long_url' => $ticket_download_url
        ]
    ]);

    $data = json_decode($response->getBody()->getContents(), true);

    return $data['link'];
}