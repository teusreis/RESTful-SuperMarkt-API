<?php

namespace App\Auth;

class AuthController
{

    public static function createJwt($id, $email, $type = "basic")
    {
        //Application Key
        $key = APIKEY;

        //Header Token
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //Payload - Content
        $payload = [
            'jti' => $id,
            'email' => $email,
            'type' => $type,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60)
        ];

        //JSON
        $header = json_encode($header);
        $payload = json_encode($payload);

        //Base 64
        $header = self::base64urlEncode($header);
        $payload = self::base64urlEncode($payload);

        //Sign
        $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
        $sign = self::base64urlEncode($sign);

        //Token
        $token = $header . '.' . $payload . '.' . $sign;

        return $token;
    }

    public static function checkAuth(): void
    {
        $http_header = apache_request_headers();

        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {

            // dd("token valido");
            $token = explode('.', $http_header['Authorization']);
            $header = $token[0];
            $payload = $token[1];

            $sign = $token[2];

            //Conferir Assinatura
            $valid = hash_hmac('sha256', $header . "." . $payload, APIKEY, true);
            $valid = self::base64urlEncode($valid);

            if ($sign !== $valid) {
                http_response_code(401);
                $response = [
                    "status" => "Unauthorized",
                    "body" => "your token is not valid!"
                ];
                echo json_encode($response);
                die();
            }
        } else {

            http_response_code(401);
            $response = [
                "status" => "Unauthorized",
                "body" => "You must use a token in order to use this api!"
            ];
            echo json_encode($response);
            die();
        }
    }

    public static function isAdmin(): void
    {
        $payloadDecoded = self::getPayloadData();

        if ($payloadDecoded->type != "admin") {
            http_response_code(403);

            $response = [
                "status" => "forbidden",
                "body" => "Only admin can access this path"
            ];

            echo json_encode($response);
            die();
        }
    }

    public static function isEmployee(): void
    {
        $payloadDecoded = self::getPayloadData();

        if ($payloadDecoded->type != "employee" && $payloadDecoded->type != "admin") {
            http_response_code(403);

            $response = [
                "status" => "forbidden",
                "body" => "you do not have permition to access this path"
            ];

            echo json_encode($response);
            die();
        }
    }

    private static function getPayloadData()
    {
        $http_header = apache_request_headers();

        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {

            $token = explode('.', $http_header['Authorization']);
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

            //Conferir Assinatura
            $valid = hash_hmac('sha256', $header . "." . $payload, APIKEY, true);
            $valid = self::base64urlEncode($valid);

            if ($sign === $valid) {
                $payloadDecoded = json_decode(self::base64url_decode($payload));

                return $payloadDecoded;
            } else {
                http_response_code(401);
                $response = [
                    "status" => "Unauthorized",
                    "body" => "your token is not valid!"
                ];
                echo json_encode($response);
                die();
            }
        }

        http_response_code(401);

        $response = [
            "status" => "Unauthorized",
            "body" => "You must use a token in order to use this api!"
        ];

        echo json_encode($response);
        die();
    }

    private static function base64urlEncode($data)
    {
        // First of all you should encode $data to Base64 string
        $b64 = base64_encode($data);

        // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
        if ($b64 === false) {
            return false;
        }

        // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
        $url = strtr($b64, '+/', '-_');

        // Remove padding character from the end of line and return the Base64URL result
        return rtrim($url, '=');
    }

    private static function base64url_decode($data, $strict = false)
    {
        // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
        $b64 = strtr($data, '-_', '+/');

        // Decode Base64 string and return the original data
        return base64_decode($b64, $strict);
    }
}
