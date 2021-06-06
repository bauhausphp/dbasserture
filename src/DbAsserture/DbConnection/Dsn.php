<?php

namespace Bauhaus\DbAsserture\DbConnection;

use TypeError;

class Dsn
{
    private string $protocol;
    private ?string $user;
    private ?string $password;
    private string $host;
    private ?string $port;
    private ?string $dbname;

    public function __construct(string $dsn)
    {
        try {
            [$this->protocol, $tail] = $this->splitInTwo('://', $dsn);
            [$head, $this->dbname] = $this->splitInTwo('/', $tail);

            [$head, $tail] = $this->splitInTwo('@', $head);
            $userAndPassword = $tail ? $head : null;
            $hostAndPort = $tail ? $tail : $head;

            [$this->user, $this->password] = $this->splitInTwo(':', $userAndPassword);
            [$this->host, $this->port] = $this->splitInTwo(':', $hostAndPort);
        } catch (TypeError $ex) {
            throw new InvalidDsnException($dsn, $ex);
        }
    }

    public function protocol(): string
    {
        return $this->protocol;
    }

    public function user(): ?string
    {
        return $this->user;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): ?string
    {
        return $this->port;
    }

    public function dbname(): ?string
    {
        return $this->dbname;
    }

    private function splitInTwo(string $delimiter, ?string $text): array
    {
        if (null === $text) {
            return [null, null];
        }

        $explored = explode($delimiter, $text);
        return [$explored[0], $explored[1] ?? null];
    }
}
