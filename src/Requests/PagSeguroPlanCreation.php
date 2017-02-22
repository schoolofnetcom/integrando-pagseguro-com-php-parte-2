<?php

namespace BrPayments\Requests;

use BrPayments\OrderInterface as Order;

class PagSeguroPlanCreation extends RequestAbstract
{
    const METHOD = 'POST';
    const URL = 'https://ws.pagseguro.uol.com.br/pre-approvals/request?';
    const URL_SANDBOX = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request?';

    public function config(Order $order = null) :array
    {
        return [
            'json'=>$order->getBody(),
            'headers'=>[
                'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
                'Content-Type' => 'application/json;charset=ISO-8859-1',
            ]
        ];
    }
}
