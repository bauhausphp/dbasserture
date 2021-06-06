<?php

namespace Bauhaus\DbAsserture\DbConnection;

use PDOException;
use RuntimeException;

class DbExecException extends RuntimeException
{
    public function __construct(PDOException $ex)
    {
        $errorInfo = implode("\n", $ex->errorInfo);
        $message = "Error while executing PDO statement\n$errorInfo";

        parent::__construct($message);
    }
}
