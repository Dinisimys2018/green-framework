<?php

namespace GF\Core\Interfaces;

interface KernelInterface
{
    public function load():static;

    public function handle();
}