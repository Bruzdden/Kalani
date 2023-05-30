<?php

interface IDB{
    public function _select(string $table, array $fields = [], array $conditions = []): array;
    public function _insert(string $table, array $data): bool;
    public function _update(string $table, string $primaryKey, int $id, array $data): bool;
    public function _delete(string $table, int $id, string $primary_key = 'id'): bool;
}