<?php

namespace BrPayments\Recurrence;

use BrPayments\OrderInterface;

class PagSeguro implements OrderInterface
{
    private $config;
    private $sender;
    private $shipping;
    private $payment;

    public function __construct(string $email, string $token, string $plan, string $reference)
    {
        $this->config = [
            'email' => $email,
            'token' => $token,
            'plan' => $plan,
            'reference' => $reference
        ];
    }

    public function customer(...$customer)
    {
        $this->sender = [
            'name' => $customer[0],
            'email' => $customer[1],
            'hash' => $customer[2],
            'phone'=> [
                'areaCode' => $customer[3],
                'number' => $customer[4],
            ],
            'documents'=> [
                [
                    'type'=>'CPF',
                    'value'=>$customer[5]
                ]
            ]
        ];
    }

    public function shipping(...$shipping)
    {
        $this->shipping = [
            'street' => $shipping[0],
            'number' => $shipping[1],
            'complement' => $shipping[2],
            'district' => $shipping[3],
            'postalCode' => $shipping[4],
            'city' => $shipping[5],
            'state' => $shipping[6],
            'country' => $shipping[7],
        ];
    }

    public function paymentMethod(...$payment)
    {
        $this->payment = [
            'type'=>'CREDITCARD',
            'creditCard'=>[
                'token'=> $payment[0],
                'holder'=> [
                    'name'=> $payment[1],
                    'birthDate'=> $payment[2],
                    'documents'=> [
                        [
                            'type'=>'CPF',
                            'value'=>$payment[3]
                        ]
                    ],
                    'phone'=> [
                        'areaCode' => $payment[4],
                        'number' => $payment[5],
                    ],
                    'billingAddress' => [
                        'street' => $payment[6],
                        'number' => $payment[7],
                        'complement' => $payment[8],
                        'district' => $payment[9],
                        'postalCode' => $payment[10],
                        'city' => $payment[11],
                        'state' => $payment[12],
                        'country' => $payment[13],
                    ]
                ]
            ],
        ];
    }

    public function getBody()
    {
        $data = [
            'plan'=> $this->config['plan'],
            'reference'=> $this->config['reference'],
            'sender'=> $this->sender,
            'paymentMethod'=> $this->payment
        ];

        $data['sender']['address'] = $this->shipping;

        return json_encode($data);
    }

    public function __toString() :string
    {
        $access = [
            'email'=>$this->config['email'],
            'token'=>$this->config['token'],
        ];

        return http_build_query($access);
    }
}
