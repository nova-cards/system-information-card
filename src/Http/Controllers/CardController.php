<?php

namespace NovaCards\SystemInformationCard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use NovaCards\SystemInformationCard\SystemInformation;

class CardController extends Controller
{
    public function index(Request $request, SystemInformation $systemInformation)
    {
        return response()->json([
            'avg' => $systemInformation->avg(),
            'mem' => $systemInformation->memory(),
            'disk' => $systemInformation->disk(),
            'systemTime' => $systemInformation->systemTime()->toIso8601ZuluString(),
            'upTime' => $systemInformation->uptime()
        ]);
    }
}
