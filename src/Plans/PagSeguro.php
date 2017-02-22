<?php

namespace BrPayments\Plans;

use BrPayments\OrderInterface;

class PagSeguro implements OrderInterface
{
    private $email;
    private $token;
    private $plan;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function setPlan(array $plan)
    {
        $this->plan = $plan;
    }

    public function getBody()
    {
        return $this->plan;
    }

    public function __toString() :string
    {
        $access = [
            'email'=>$this->email,
            'token'=>$this->token,
        ];

        return http_build_query($access);
    }
}
