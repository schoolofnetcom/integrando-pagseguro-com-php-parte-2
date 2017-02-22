<?php

namespace BrPayments\Requests;

use BrPayments\OrderInterface as Order;

class PagSeguroRecurrence extends RequestAbstract
{
    const METHOD = 'POST';
    const URL = 'https://ws.pagseguro.uol.com.br/pre-approvals?';
    const URL_SANDBOX = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?';

    public function config(Order $order = null) :array
    {
        $body = json_encode($order->getBody());
        $body = str_replace('\\', '', $body);
        $body = mb_substr($body, 1, -1);
        return [
            'body'=>$body,
            'headers'=>[
                'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
                'Content-Type' => 'application/json;charset=ISO-8859-1',
            ]
        ];
    }
}
