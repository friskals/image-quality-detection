<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageQualityRequest;
use App\Libraries\LambdaFunctionClient;

class ImageQualityDetectionController extends Controller
{
    public function detectExposure(ImageQualityRequest $request)
    {
        $payload = [
            'min_level' => 75,
            'max_level' => 150
        ];

        if ($request->hasFile('image')) {
            $image = file_get_contents($request->image);
            $file = 'data:image/jpeg;base64,' . base64_encode($image);
            $given_image = ['file' => $file];
        } else {
            $given_image = ['url' => $request->image];
        }

        $payload = array_merge($given_image, $payload);
        

        $function_name = env('LAMBDA_FUNCTION_DETECT_EXPOSURE');

        $result = LambdaFunctionClient::invokeFunction($payload, $function_name);

        if (isset($result->errorMessage)) {
            return response()->json(['error' => $result, 500]);
        }

        return response()->json(['data' => $result]);
    }

    public function detectBlurry(ImageQualityRequest $request)
    {
        $payload = [
            'threshold' => 300
        ];

        if ($request->hasFile('image')) {
            $image = file_get_contents($request->image);
            $file = 'data:image/jpeg;base64,' . base64_encode($image);
            $given_image = ['file' => $file];
        } else {
            $given_image = ['url' => $request->image];
        }

        $payload = array_merge($payload, $given_image);

        $function_name = env('LAMBDA_FUNCTION_DETECT_BLURRY');

        $result = LambdaFunctionClient::invokeFunction($payload, $function_name);

        if (isset($result->errorMessage)) {
            return response()->json(['error' => $result, 500]);
        }

        return response()->json(['data' => $result]);
    }
}
