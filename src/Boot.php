<?php

namespace Tlab;

use Symfony\Component\HttpFoundation\Request;

class Boot
{
    /**
     * @var Boot
     */
    private static $instance;

    /**
     * @var Request
     */
    private $request;

    /**
     * @return Boot
     */
    public static function getInstance(): Boot
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    private function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
