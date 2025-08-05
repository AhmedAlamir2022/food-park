@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blogs</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Blogs</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
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
                                <th>Image</th>
                                <th>Title</th>
                                <th>category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img width="50px" src="{{ asset($blog->image) }}" alt="Image"></td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->category->name }}</td>
                                    <td>{{ $blog->user->name }}</td>
                                    <td><span
                                            class="badge {{ $blog->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $blog->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $blog->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $blog->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.blogs.destroy', $blog->id) }}"
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
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
