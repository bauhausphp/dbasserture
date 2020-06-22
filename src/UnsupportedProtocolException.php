<?php

namespace Bauhaus\DbAsserture;

use RuntimeException;

class UnsupportedProtocolException extends RuntimeException
{
    public function __construct(string $unsupportedProtocol, array $supportedProtocols)
    {
        $supportedProtocols = implode(',', $supportedProtocols);
        $message = "Unsupported protocol provided '$unsupportedProtocol' (supported ones '$supportedProtocols)";

        parent::__construct($message);
    }
}
