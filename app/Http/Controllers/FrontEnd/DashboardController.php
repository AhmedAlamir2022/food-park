<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        // $deliveryAreas = DeliveryArea::where('status', 1)->get();
        // $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        // $orders = Order::where('user_id', auth()->user()->id)->get();
        // $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        // $reviews = ProductRating::where('user_id', auth()->user()->id)->get();
        // $wishlist = Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        // $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        // $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        // $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();

        return view('frontend.dashboard.index');
    }
}