<?php

namespace BrPayments\Plans;

use PHPUnit\Framework\TestCase;

class PagSeguroTest extends TestCase
{
    //https://dev.pagseguro.uol.com.br/referencia-da-api/api-de-pagamentos-pagseguro#!/ws_pagseguro_uol_com_br/request_xml

    public function testPlanBodyGeneration () {
        $plan = [
            'reference' => 'plan1',
            'preApproval' => [
                'name' => 'Plano bronze - mensal',
                'charge' =>'MANUAL', // outro valor pode ser AUTO
                'period' => 'MONTHLY', //WEEKLY, BIMONTHLY, TRIMONTHLY, SEMIANNUALLY, YEARLY
                'amountPerPayment' => '125.00', // obrigatório para o charge AUTO - mais que 1.00, menos que 2000.00
                'membershipFee'=> '50.00', //opcional - cobrado com primeira parcela
                'trialPeriodDuration' => 30, //opcional
                'details' => 'Decrição do plano', //opcional
            ]
        ];

        $pagseguro = new PagSeguro(
            'email@email',
            'token'
        );

        $pagseguro->setPlan($plan);

        //$expected = '{"reference":"plan1","preApproval":{"name":"Plano bronze - mensal","charge":"MANUAL","period":"MONTHLY","amountPerPayment":"125.00","membershipFee":"50.00","trialPeriodDuration":30,"details":"Decri\u00e7\u00e3o do plano"}}';
        $this->assertTrue(is_array($pagseguro->getBody()));
    }

    public function testGetAuthentication()
    {
        $pagseguro = new PagSeguro(
            'email@email',
            'token'
        );

        $expected = 'email=email%40email&token=token';
        $this->assertEquals($expected, (string)$pagseguro);
    }
}
