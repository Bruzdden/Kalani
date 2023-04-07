<?php

interface IDB{
    public function _connect(string $dbhost = "",string $dbuser = "",string $dbpass = "",string $dbname = "");
    public function _select(string $table, array $fields = [], array $conditions = []): array;
    public function _insert(string $table, array $data): bool;
    public function _update(string $table, int $id, array $data): bool;
    public function _delete(string $table, int $id): bool;
}