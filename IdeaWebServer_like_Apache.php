<?php

if (!function_exists("apache_request_headers")) {
    function apache_request_headers()
    {
        static $headers = NULL;

        if (!$headers) {
            $headers = array();
            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) === "HTTP_") {
                    $headers[str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))))] = $value;
                }
            }
        }

        return $headers;
    }
}

if (!function_exists("getallheaders")) {
    function getallheaders()
    {
        return apache_request_headers();
    }
}

if (!function_exists("apache_response_headers")) {
    function apache_response_headers()
    {
        $arh = array();
        $headers = headers_list();
        foreach ($headers as $header) {
            $header = explode(":", $header);
            $arh[array_shift($header)] = trim(implode(":", $header));
        }

        return $arh;
    }
}

if (!function_exists("http_response_code")) {
    function http_response_code($_code = NULL)
    {
        static $codes = array(
            "100" => "Continue",
            "101" => "Switching Protocols",
            "200" => "OK",
            "201" => "Created",
            "202" => "Accepted",
            "203" => "Non-Authoritative Information",
            "204" => "No Content",
            "205" => "Reset Content",
            "206" => "Partial Content",
            "300" => "Multiple Choices",
            "301" => "Moved Permanently",
            "302" => "Moved Temporarily",
            "303" => "See Other",
            "304" => "Not Modified",
            "305" => "Use Proxy",
            "400" => "Bad Request",
            "401" => "Unauthorized",
            "402" => "Payment Required",
            "403" => "Forbidden",
            "404" => "Not Found",
            "405" => "Method Not Allowed",
            "406" => "Not Acceptable",
            "407" => "Proxy Authentication Required",
            "408" => "Request Time-out",
            "409" => "Conflict",
            "410" => "Gone",
            "411" => "Length Required",
            "412" => "Precondition Failed",
            "413" => "Request Entity Too Large",
            "414" => "Request-URI Too Large",
            "415" => "Unsupported Media Type",
            "500" => "Internal Server Error",
            "501" => "Not Implemented",
            "502" => "Bad Gateway",
            "503" => "Service Unavailable",
            "504" => "Gateway Time-out",
            "505" => "HTTP Version not supported",
        );

        static $code = NULL;

        if ($_code !== NULL) {
            if (!isset($codes[$_code])) {
                exit("Unknown http status code \"" . htmlentities($_code) . "\"");
            }

            $protocol = (isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.0");
            header($protocol . " " . $_code . " " . $codes[$_code]);
            $code = $_code;
        }

        return ($code !== NULL ? $code : 200);
    }
}
