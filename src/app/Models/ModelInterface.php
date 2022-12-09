<?php

namespace App\Models;

interface ModelInterface
{
    public function create(array $arguments): self;
    public function update(array $arguments): self;
    public function find(int $id): self;
    public function delete(): bool;
}