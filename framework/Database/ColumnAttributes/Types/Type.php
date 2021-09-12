<?php

namespace GF\Database\ColumnAttributes\Types;

class Type
{
    protected string $type;


    public function __construct(protected ?int $length = null)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }
}