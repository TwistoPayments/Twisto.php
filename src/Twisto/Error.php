<?php
namespace Twisto;

class Error extends \Exception
{
    public $data;

    public function __construct($message = "", $data = null, $code = 0, \Exception $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

}