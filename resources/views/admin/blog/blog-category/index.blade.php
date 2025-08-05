@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog Categories</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Blog Categories</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.blog-category.create') }}" class="btn btn-primary">
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
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><span class="badge {{ $category->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $category->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $category->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $category->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blog-category.edit', $category->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.blog-category.destroy', $category->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>




                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
