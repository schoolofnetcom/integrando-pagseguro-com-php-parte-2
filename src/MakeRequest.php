<?php

namespace BrPayments;

use BrPayments\Requests\RequestInterface as Request;
use BrPayments\OrderInterface as Order;
use GuzzleHttp\Client;

class MakeRequest
{
    private $client;
    private $request;

    public function __construct(Request $request)
    {
        $this->client = new Client;
        $this->request = $request;
    }

    public function make(Order $order, bool $sandbox = null)
    {
        $response = $this->client->request(
            $this->request->getMethod(),
            $this->request->getUrl($order, $sandbox),
            $this->request->config($order)
        );

        return $response->getBody();
    }
}
