<?php

namespace Utils;

function validate_id($id): void
{
    if (!is_string($id) || !preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $id)) {
        throw new \Exception("ID must be a valid UUID");
    }
}
