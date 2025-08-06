@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Reservation Times</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Times</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.reservation-time.create') }}" class="btn btn-primary">
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($reservationTimes as $reservationTime)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reservationTime->start_time }}</td>
                                    <td>{{ $reservationTime->end_time }}</td>
                                    <td><span class="badge {{ $reservationTime->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $reservationTime->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $reservationTime->created_at->format('M d,Y') }}

                                    </td>
                                    <td>
                                        {{ $reservationTime->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reservation-time.edit', $reservationTime->id) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.reservation-time.destroy', $reservationTime->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $reservationTimes->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
