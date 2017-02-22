<?php

namespace BrPayments\MakeRequest\PagSeguro;

use PHPUnit\Framework\TestCase;

use BrPayments\Notifications\PagSeguro;
use BrPayments\Requests\PagSeguroNotification;
use BrPayments\MakeRequest;

class PagSeguroNotificationTest extends TestCase
{
    public function testPagSeguroRequest()
    {
        $access = [
            'email'=>'erik.figueiredo@gmail.com',
            'token'=>'E7EF160DE74646CE80AB18EDDA257F1B',
            'notificationCode'=>'E754313BD3C5D3C5973EE400CFAF2FD8E5A8'
        ];

        $pag_seguro = new PagSeguro($access);
        $pag_seguro_request = new PagSeguroNotification;

        $response = (new MakeRequest($pag_seguro_request))->make($pag_seguro, true);

        $result = (string)$response;

        $this->assertTrue(is_string($result));
    }
}
