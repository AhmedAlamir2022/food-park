@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Coupon</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary">
                        Create new
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Quantity</th>
                                <th>Discount Type</th>
                                <th>Discount</th>
                                <th>Expire Date</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->quantity }}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->expire_date }}</td>
                                    <td><span class="badge {{ $coupon->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $coupon->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $coupon->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $coupon->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.coupon.destroy', $coupon->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>




                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
