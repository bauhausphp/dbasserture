<?php

namespace Bauhaus\DbAsserture;

use PDOStatement;
use RuntimeException;

class DatabaseExecException extends RuntimeException
{
    public function __construct(PDOStatement $statement)
    {
        $errorInfo = implode("\n", $statement->errorInfo());
        $message = "Error while executing PDO statement\n$errorInfo";

        parent::__construct($message);
    }
}
