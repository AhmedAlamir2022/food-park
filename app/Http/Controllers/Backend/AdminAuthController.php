<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    function index()
    {
        return view('admin.auth.login');
    }

    function dashboard()
    {
        $todaysOrdersRows = Order::whereDate('created_at', now()->format('Y-m-d'))->latest()->paginate(10);
        $todaysOrders = Order::whereDate('created_at', now()->format('Y-m-d'))->count();
        $todaysEarnings = Order::whereDate('created_at', now()->format('Y-m-d'))->where('order_status', 'delivered')->sum('grand_total');

        $thisMonthsOrders = Order::whereMonth('created_at', now()->month)->count();
        $thisMonthsEarnings = Order::whereMonth('created_at', now()->month)->where('order_status', 'delivered')->sum('grand_total');

        $thisYearOrders = Order::whereYear('created_at', now()->year)->count();
        $thisYearEarnings = Order::whereYear('created_at', now()->year)->where('order_status', 'delivered')->sum('grand_total');

        $totalOrders = Order::count();
        $totalEarnings = Order::where('order_status', 'delivered')->sum('grand_total');

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalProducts = Product::count();
        $totalBlogs = Blog::count();

        return view('admin.dashboard.index', compact(
            'todaysOrders', 'todaysEarnings',
            'thisMonthsOrders', 'thisMonthsEarnings',
            'thisYearOrders', 'thisYearEarnings',
            'totalOrders', 'totalEarnings',
            'totalUsers', 'totalAdmins',
            'totalProducts', 'totalBlogs',
            'todaysOrdersRows'
        ));
    }

    // function clearNotification() {
    //     $notification = OrderPlacedNotification::query()->update(['seen' => 1]);

    //     toastr()->success('Notification Cleared Successfully!');
    //     return redirect()->back();
    // }

    function forgetPassword()
    {
        return view('admin.auth.forget-password');
    }
}
