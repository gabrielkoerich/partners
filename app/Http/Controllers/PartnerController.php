<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PartnerController
{
    private $fetchUrl = 'https://api.filtered.ai/q/get-partner-availability';

    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function index()
    {
        try {
            $response = $this->http->get($this->getUrl());

            $data = json_decode($response->getBody(), true);

            return [
                'error' => false,
                'data' => $data,
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function popular(Request $request)
    {
        // save data $request->all();
        return 'D2BD6DBD7034789514F13034C4A0CD96';
    }

    public function getUrl()
    {
        return $this->fetchUrl;
    }
}
