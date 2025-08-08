@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Admin Management</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Admins</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.admin-management.create') }}" class="btn btn-primary">
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
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img width="60px" src="{{ asset($admin->avatar) }}" alt="Image"></td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if ($admin->id === 1)
                                            {{ 'Super Admin' }}
                                        @else
                                            {{ 'Admin' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $admin->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $admin->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        @if ($admin->id != 1)
                                            <a href="{{ route('admin.admin-management.edit', $admin->id) }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('admin.admin-management.destroy', $admin->id) }}"
                                                class="btn btn-danger delete-item ml-2">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-warning">Not allowed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
