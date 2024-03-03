<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
 
    public function index()
    {
        $settings = Setting::all();
        return response()->json(['settings' => $settings]);
    }

    
    public function setSetting(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string' // Adjust validation as needed
        ]);
        $setting = Setting::updateOrCreate(
            ['key' => $request->key],
            ['value' => $request->value]
        );
    
        return response()->json(['message' => 'Setting saved successfully.', 'setting' => $setting]);
    }
    

    public function getSetting($key)
{
    $setting = Setting::where('key', $key)->first();

    if (!$setting) {
        return response()->json(['message' => 'Setting not found.'], 404);
    }

    return response()->json(['setting' => $setting]);
}

}
