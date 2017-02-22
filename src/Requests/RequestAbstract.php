<?php

namespace BrPayments\Requests;

use BrPayments\OrderInterface as Order;

abstract class RequestAbstract implements RequestInterface
{
    private $child_const;

    public function getUrl(Order $order, bool $sandbox = null) :string
    {
        if ($sandbox) {
            return $this->getChildConstant('url_sandbox') . (string)$order;
        }
        return $this->getChildConstant('url') . (string)$order;
    }

    public function getMethod() :string
    {
        return $this->getChildConstant('method');
    }

    private function getChildConstant($const)
    {
        if (!$this->child_const) {
            $child = get_class($this);
            $this->child_const = [
                'url'=> constant($child . '::URL'),
                'url_sandbox'=>constant($child . '::URL_SANDBOX'),
                'method'=>constant($child . '::METHOD'),
            ];
        }

        return $this->child_const[$const];
    }
}
