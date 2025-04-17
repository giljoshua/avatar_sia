<?php

namespace App\Http\Controllers;

use App\Models\SmartLight;
use Illuminate\Http\Request;

class SmartLightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $smartLights = SmartLight::all();
        return view('smart_lights.index', compact('smartLights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('smart_lights.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:On,Off',
            'location' => 'required',
            'brightness' => 'required|integer|min:0|max:100',
        ]);

        SmartLight::create($request->all());
        return redirect()->route('smart-lights.index')
                        ->with('success', 'Smart light added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SmartLight $smartLight)
    {
        return view('smart_lights.show', compact('smartLight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmartLight $smartLight)
    {
        return view('smart_lights.edit', compact('smartLight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SmartLight $smartLight)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:On,Off',
            'location' => 'required',
            'brightness' => 'required|integer|min:0|max:100',
        ]);

        $smartLight->update($request->all());
        return redirect()->route('smart-lights.index')
                        ->with('success', 'Smart light updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmartLight $smartLight)
    {
        $smartLight->delete();
        return redirect()->route('smart-lights.index')
                        ->with('success', 'Smart light deleted successfully.');
    }
    
    /**
     * Toggle light status between On/Off
     */
    public function toggleStatus(SmartLight $smartLight)
    {
        $smartLight->status = ($smartLight->status === 'On') ? 'Off' : 'On';
        $smartLight->save();
        
        return redirect()->route('smart-lights.index')
                        ->with('success', "Light {$smartLight->name} turned {$smartLight->status}");
    }
    
    /**
     * Adjust brightness of a light
     */
    public function adjustBrightness(Request $request, SmartLight $smartLight)
    {
        $request->validate([
            'brightness' => 'required|integer|min:0|max:100',
        ]);
        
        $smartLight->brightness = $request->brightness;
        $smartLight->save();
        
        return redirect()->route('smart-lights.index')
                        ->with('success', "Brightness of {$smartLight->name} adjusted successfully");
    }
}
