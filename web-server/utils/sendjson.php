<?php

namespace Utils;

function sendjson($data): void
{
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}
