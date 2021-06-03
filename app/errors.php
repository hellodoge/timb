<?php

namespace app;

const INTERNAL_SERVER_ERROR = 500;
const NOT_FOUND = 404;
const BAD_REQUEST = 400;
const OK = 200;

function sendResponse(int $status, string $message) {
    http_response_code($status);
    $response = array();
    $response['message'] = $message;
    echo json_encode($response);
}

function internalServerErrorResponse() {
    sendResponse(
        INTERNAL_SERVER_ERROR,
        "Unknown error, please contact service administrators"
    );
}