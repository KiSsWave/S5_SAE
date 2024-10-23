<?php

namespace nrv\core\dto;

use nrv\core\dto\DTO;

class AuthDTO extends DTO
{
    public string $userId;
    public array $tokens;

    public function __construct(string $userId, array $tokens)
    {
        $this->userId = $userId;
        $this->tokens = $tokens;
    }
}