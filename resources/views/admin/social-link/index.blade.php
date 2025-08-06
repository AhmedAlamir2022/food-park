@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Social Links</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Social Links</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.social-link.create') }}" class="btn btn-primary">
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
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($links as $link)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> <i class="{{ $link->icon }}" style="font-size:30px"></i></td>
                                    <td>{{ $link->name }}</td>
                                    <td><span class="badge {{ $link->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $link->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $link->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>
                                        {{ $link->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.social-link.edit', $link->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.social-link.destroy', $link->id) }}"
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
                    {{ $links->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
