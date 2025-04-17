<?php

namespace App\Http\Controllers;

use App\Models\SmartLight;
use Illuminate\Http\Request;
use PDF; // Add PDF facade

class SmartLightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SmartLight::query();
        
        // Search filter implementation
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by location if provided
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', "%{$request->location}%");
        }
        
        // Pagination implementation (10 items per page)
        $smartLights = $query->orderBy('id', 'desc')->paginate(10);
        
        // Get unique locations for the filter dropdown
        $locations = SmartLight::distinct()->pluck('location');
        
        return view('smart_lights.index', compact('smartLights', 'locations'));
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

    /**
     * Generate PDF of smart lights data
     */
    public function generatePDF(Request $request)
    {
        $query = SmartLight::query();
        
        // Apply the same filters as in the index method
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', "%{$request->location}%");
        }
        
        $smartLights = $query->orderBy('id', 'desc')->get();
        
        $pdf = PDF::loadView('smart_lights.pdf', compact('smartLights'));
        
        return $pdf->download('smart-lights-report.pdf');
    }
}
