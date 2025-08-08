<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = DeliveryArea::latest()->paginate(10);
        return view('admin.delivery-area.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'area_name' => ['required', 'max:255'],
            'min_delivery_time' => ['required', 'max:255'],
            'max_delivery_time' => ['required', 'max:255'],
            'delivery_fee' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);

        $area = new DeliveryArea();
        $area->area_name = $request->area_name;
        $area->min_delivery_time = $request->min_delivery_time;
        $area->max_delivery_time = $request->max_delivery_time;
        $area->delivery_fee = $request->delivery_fee;
        $area->status = $request->status;
        $area->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.delivery-area.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $area = DeliveryArea::findOrFail($id);
        return view('admin.delivery-area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'area_name' => ['required', 'max:255'],
            'min_delivery_time' => ['required', 'max:255'],
            'max_delivery_time' => ['required', 'max:255'],
            'delivery_fee' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);

        $area = DeliveryArea::findOrFail($id);
        $area->area_name = $request->area_name;
        $area->min_delivery_time = $request->min_delivery_time;
        $area->max_delivery_time = $request->max_delivery_time;
        $area->delivery_fee = $request->delivery_fee;
        $area->status = $request->status;
        $area->save();

        toastr()->info('Updated Successfully!');

        return to_route('admin.delivery-area.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DeliveryArea::findOrFail($id)->delete();

            return response(['status' => 'info', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
