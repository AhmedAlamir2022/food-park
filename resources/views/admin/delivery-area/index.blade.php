@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Delivery Areas</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.delivery-area.create') }}" class="btn btn-primary">
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
                                <th>Area</th>
                                <th>Delivery Fee</th>
                                <th>Min Delivery Time</th>
                                <th>Min Delivery Time</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($areas as $area)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $area->area_name }}</td>
                                    <td>{{ $area->delivery_fee }}</td>
                                    <td>{{ $area->min_delivery_time }}</td>
                                    <td>{{ $area->max_delivery_time }}</td>
                                    <td><span class="badge {{ $area->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $area->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $area->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $area->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.delivery-area.edit', $area->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.delivery-area.destroy', $area->id) }}"
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
                    {{ $areas->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
