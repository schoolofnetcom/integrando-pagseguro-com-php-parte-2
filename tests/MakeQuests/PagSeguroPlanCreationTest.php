<?php

namespace BrPayments\MakeRequest\PagSeguro;

use PHPUnit\Framework\TestCase;
use BrPayments\Plans\PagSeguro;
use BrPayments\Requests\PagSeguroPlanCreation as PagSeguroRequest;
use BrPayments\MakeRequest;

class PagSeguroPlanCreationTest extends TestCase
{
    public function testPagSeguroRequest()
    {
        $plan = [
            'reference' => 'plan1',
            'preApproval' => [
                'name' => 'Plano bronze - mensal',
                'charge' =>'MANUAL', // AUTO
                'period' => 'MONTHLY', //WEEKLY, BIMONTHLY, TRIMONTHLY, SEMIANNUALLY, YEARLY
                'amountPerPayment' => '125.00', // obrigatório para o charge AUTO - mais que 1.00, menos que 2000.00
                'membershipFee'=> '50.00', //opcional - cobrado com primeira parcela
                'trialPeriodDuration' => 30, //opcional
                'details' => 'Decrição do plano', //opcional
            ]
        ];

        $pagseguro = new PagSeguro(
            'erik.figueiredo@gmail.com',
            'E7EF160DE74646CE80AB18EDDA257F1B'
        );

        $pagseguro->setPlan($plan);

        //requisição
        $pag_seguro_request = new PagSeguroRequest();

        $response = (new MakeRequest($pag_seguro_request))->make($pagseguro, true);

        $object = json_decode((string)$response);

        $this->assertTrue(is_string($object->code));
    }
}
