<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    function index()
    {
        // This method can be used to show a general order index page
        $orders = Order::with('user')->latest()->paginate(10); // Assuming you have an Order model
        return view('admin.order.index', compact('orders'));
    }

    function pendingOrderIndex()
    {
        $pending_orders = Order::with('user')->where('order_status', 'pending')->latest()->paginate(10);
        return view('admin.order.pending-order-index', compact('pending_orders'));
    }

    function inProcessOrderIndex()
    {
        $in_process_orders = Order::with('user')->where('order_status', 'in_process')->latest()->paginate(10);
        return view('admin.order.inprocess-order-index', compact('in_process_orders'));
    }

    function deliveredOrderIndex()
    {
        $delivered_orders = Order::with('user')->where('order_status', 'delivered')->latest()->paginate(10);
        return view('admin.order.delivered-order-index', compact('delivered_orders'));
    }

    function declinedOrderIndex()
    {
        $declined_orders = Order::with('user')->where('order_status', 'declined')->latest()->paginate(10);
        return view('admin.order.declined-order-index', compact('declined_orders'));
    }

    function show($id)
    {
        $order = Order::findOrFail($id);
        // $notification = OrderPlacedNotification::where('order_id', $order->id)->update(['seen' => 1]);

        return view('admin.order.show', compact('order'));
    }

    function getOrderStatus(string $id): Response
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    function orderStatusUpdate(Request $request, string $id): RedirectResponse|Response
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if ($request->ajax()) {
            return response(['message' => 'Order Status Updated!']);
        } else {
            toastr()->info('Status Updated Successfully!');

            return redirect()->back();
        }
    }

    function destroy(string $id): Response
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response(['status' => 'info', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
