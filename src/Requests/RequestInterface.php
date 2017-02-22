<?php

namespace BrPayments\Requests;

use BrPayments\OrderInterface as Order;

interface RequestInterface
{
    public function getUrl(Order $order, bool $sandbox = null) :string;
    public function getMethod() :string;
    public function config(Order $order = null) :array;
}
