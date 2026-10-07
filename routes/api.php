<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('directions', function () {
    $from = request('from');
    $to = request('to');

    $resolveCoord = function ($input) {
        if (preg_match('/^-?\d+(\.\d+)?,\s*-?\d+(\.\d+)?$/', trim($input))) {
            $parts = explode(',', trim($input));
            return ['lat' => trim($parts[0]), 'lng' => trim($parts[1])];
        }
        $opts = [
            'http' => [
                'header' => "User-Agent: PelayananUmumApp/1.0\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $url = 'https://nominatim.openstreetmap.org/search?format=json&q=' . urlencode($input) . '&countrycodes=id&limit=1';
        $res = @file_get_contents($url, false, $context);
        if ($res) {
            $data = json_decode($res, true);
            if (!empty($data[0])) {
                return ['lat' => $data[0]['lat'], 'lng' => $data[0]['lon']];
            }
        }
        return null;
    };

    $fromCoord = $resolveCoord($from);
    $toCoord = $resolveCoord($to);

    if (!$fromCoord || !$toCoord) {
        return response()->json(['status' => 'NOT_FOUND', 'routes' => []], 404);
    }

    $opts = [
        'http' => [
            'header' => "User-Agent: PelayananUmumApp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $osrmUrl = "https://router.project-osrm.org/route/v1/driving/{$fromCoord['lng']},{$fromCoord['lat']};{$toCoord['lng']},{$toCoord['lat']}?overview=full&geometries=geojson";
    $osrmRes = @file_get_contents($osrmUrl, false, $context);

    if ($osrmRes) {
        $osrmData = json_decode($osrmRes, true);
        return response()->json($osrmData);
    }

    return response()->json(['status' => 'ERROR', 'message' => 'Routing service unavailable'], 500);
});