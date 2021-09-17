<?php

/**
 * @project: tsb
 *
 * @author : Vedat Ünlü <vedatunlu10@gmail.com>
 * @created at 9/17/21
 *
 * @license GPL
 */

function csrf_token() {
    return bin2hex(random_bytes(35));
}

function create_csrf_token() {
    if (isset($_SESSION['csrf_token'])) {
        return $_SESSION['csrf_token'];
    }
    $token = csrf_token();
    $_SESSION['csrf_token'] = $token;
    $_SESSION['csrf_token_time'] = time();
    return $token;
}

function csrf_token_tag() {
    $token = create_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

 