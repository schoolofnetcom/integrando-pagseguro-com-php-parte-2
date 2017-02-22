<?php

namespace BrPayments;

use BrPayments\Notifications\PagSeguro as Notification;
use BrPayments\Payments\PagSeguro as Payment;
use BrPayments\Recurrence\PagSeguro as Recurrence;
use BrPayments\Requests\PagSeguroNotification as RequestNotification;
use BrPayments\Requests\PagSeguro as Request;
use BrPayments\Requests\PagSeguroRecurrence as RecurrenceRequest;
use BrPayments\MakeRequest;

class PagSeguro
{
    private $email;
    private $token;
    private $sandbox;

    public function __construct(string $email, string $token, bool $sandbox = false)
    {
        $this->email = $email;
        $this->token = $token;
        $this->sandbox = $sandbox;

    }

    //exercicio - criar um método para criação de planos

    public function payment(string $reference, array $customer, array $shipping, array $products, string $currency = "BRL")
    {
        $payment = new Payment([
            'email'=>$this->email,
            'token'=>$this->token,
            'currency'=>$currency,
            'reference'=>$reference
        ]);
        call_user_func_array([$payment, 'customer'], $customer);
        call_user_func_array([$payment, 'shipping'], $shipping);
        foreach ($products as &$product) {
            call_user_func_array([$payment, 'addProduct'], $product);
        }

        $request = new Request();
        $response = (new MakeRequest($request))->make($payment, $this->sandbox);
        $xml = new \SimpleXMLElement((string)$response);
        return [
            'xml' => $xml,
            'url'=> $request->getUrlFinal($xml->code, $this->sandbox)
        ];

    }

    public function notification(string $notificationCode)
    {
        $notification = new Notification([
            'email'=>$this->email,
            'token'=>$this->token,
            'notificationCode'=>$notificationCode
        ]);
        $request = new RequestNotification;
        return (new MakeRequest($request))->make($notification, $this->sandbox);
    }

    public function recurrence(string $plan, string $reference, array $customer, array $shipping, array $payment)
    {
        $recurrence = new Recurrence($this->email, $this->token, $plan, $reference);
        call_user_func_array([$recurrence, 'customer'], $customer);
        call_user_func_array([$recurrence, 'shipping'], $shipping);
        call_user_func_array([$recurrence, 'paymentMethod'], $payment);

        $request = new RecurrenceRequest;
        return (new MakeRequest($request))->make($recurrence, $this->sandbox);
    }

    public function session()
    {
        $access = [
            'email' => $this->email,
            'token' => $this->token
        ];
        $url = 'https://ws.pagseguro.uol.com.br/v2/sessions';
        if ($this->sandbox) {
            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';
        }
        $url .= '?' . http_build_query($access);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
