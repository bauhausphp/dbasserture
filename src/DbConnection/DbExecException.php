<?php

namespace Bauhaus\DbAsserture\DbConnection;

use PDOStatement;
use RuntimeException;

class DbExecException extends RuntimeException
{
    public function __construct(PDOStatement $statement)
    {
        $errorInfo = implode("\n", $statement->errorInfo());
        $message = "Error while executing PDO statement\n$errorInfo";

        parent::__construct($message);
    }
}
