@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pending Orders</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Pending Orders</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($pending_orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->invoice_id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->product_qty }}</td>
                                    <td>{{ $order->grand_total . ' ' . strtoupper($order->currency_name) }}</td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>
                                        @if ($order->order_status === 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @elseif ($order->order_status === 'declined')
                                            <span class="badge badge-danger">Declined</span>
                                        @else
                                            <span class="badge badge-warning">{{ ucfirst($order->order_status) }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('M d,Y') }}

                                    </td>
                                    <td>
                                        {{ $order->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="javascript:;" class="btn btn-warning ml-2 order_status_btn"
                                            data-id="{{ $order->id }}" data-toggle="modal" data-target="#order_modal">
                                            <i class="fas fa-truck-loading"></i>
                                        </a>

                                        <a href="{{ route('admin.orders.destroy', $order->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No orders found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $pending_orders->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="order_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="order_status_form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Payment Status</label>
                            <select class="form-control payment_status" name="payment_status" id="">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="">Order Status</label>
                            <select class="form-control order_status" name="order_status" id="">
                                <option value="pending">Pending</option>
                                <option value="in_process">In Process</option>
                                <option value="delivered">Delivered</option>
                                <option value="declined">Declined</option>

                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit_btn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var orderId = '';

            $(document).on('click', '.order_status_btn', function() {
                let id = $(this).data('id');

                orderId = id;

                let paymentStatus = $('.payment_status option');
                let orderStatus = $('.order_status option');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.orders.status', ':id') }}'.replace(":id", id),
                    beforeSend: function() {
                        $('.submit_btn').prop('disabled', true);
                    },
                    success: function(response) {
                        paymentStatus.each(function() {
                            if ($(this).val() == response.payment_status) {
                                $(this).attr('selected', 'selected');
                            }
                        })

                        orderStatus.each(function() {
                            if ($(this).val() == response.order_status) {
                                $(this).attr('selected', 'selected');
                            }
                        })

                        $('.submit_btn').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {

                    }
                })
            })

            $('.order_status_form').on('submit', function(e) {
                e.preventDefault();
                let formContent = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.orders.status-update', ':id') }}'.replace(":id",
                        orderId),
                    data: formContent,
                    success: function(response) {
                        $('#order_modal').modal("hide");
                        $('#pendingorder-table').DataTable().draw();

                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message);
                    }
                })
            })
        })
    </script>
@endpush
