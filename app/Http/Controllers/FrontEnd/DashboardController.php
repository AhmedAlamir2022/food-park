<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddresses = Address::with('deliveryArea')->where('user_id', auth()->id())->get();

        $orders = Order::with(['userAddress', 'orderItems'])->where('user_id', auth()->user()->id)->get();
        // $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        // $reviews = ProductRating::where('user_id', auth()->user()->id)->get();
        // $wishlist = Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        // $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        // $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        // $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();
        // dump($deliveryAreas);
        return view('frontend.dashboard.index', compact('deliveryAreas', 'userAddresses', 'orders'));
    }

    function createAddress(Request $request)
    {

        $request->validate([
            'area' => ['required', 'integer'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required'],
            'type' => ['required', 'in:home,office'],
        ]);

        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        toastr()->success('Created Successfully');

        return redirect()->back();
    }

    function updateAddress(string $id, Request $request)
    {
        $request->validate([
            'area' => ['required', 'integer'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required'],
            'type' => ['required', 'in:home,office'],
        ]);

        $address = Address::findOrFail($id);
        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->type = $request->type;
        $address->save();

        toastr()->success('Updated Successfully');

        return redirect()->back();
    }

    function destroyAddress(string $id)
    {
        $address = Address::findOrFail($id);
        if ($address && $address->user_id === auth()->user()->id) {
            $address->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        }
        return response(['status' => 'error', 'message' => 'something went wrong!']);
    }
}
