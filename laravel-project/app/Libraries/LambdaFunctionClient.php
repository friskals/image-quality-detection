<?php

namespace App\Libraries;

use Aws\Lambda\LambdaClient;

class LambdaFunctionClient
{
    public static function invokeFunction($payload, $function_name, $invocation_type = 'RequestResponse')
    {
        try {
            $client = self::setUpClient();

            $result = $client->invoke([
                'FunctionName' => $function_name,
                'InvocationType' => $invocation_type,
                'Payload' => json_encode($payload),
            ])->get('Payload')->getContents();

            return json_decode($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function setUpClient()
    {
        return new LambdaClient([
            'version' => env('LAMBDA_FUNCTION_VERSION'),
            'region' => env('LAMBDA_FUNCTION_DEFAULT_REGION')
        ]);
    }
}
