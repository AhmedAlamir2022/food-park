<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    function index()
    {
        $reservations = Reservation::latest()->paginate(10);
        return view('admin.reservation.index', compact('reservations'));
    }

    function update(Request $request): Response
    {
        $reservation = Reservation::findOrFail($request->id);
        $reservation->status = $request->status;
        $reservation->save();
        return response(['status' => 'info', 'message' => 'updated successfully!']);
    }

    function destroy(string $id): Response
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return response(['status' => 'info', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
