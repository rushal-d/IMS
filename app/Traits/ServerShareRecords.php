<?php

namespace App\Traits;


class ServerShareRecords
{
    public static function fetchData($url, $post_fields)
    {
        $post_fields = http_build_query($post_fields);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CAINFO, public_path('cacert.pem'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        dd($server_output);

// Further processing ...
        if ($server_output == "OK") {

        } else {

        }
    }
}