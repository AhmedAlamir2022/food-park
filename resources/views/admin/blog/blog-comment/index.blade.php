@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blogs Comments</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Comments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Blog</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($comments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $comment->blog->title }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->comment }}</td>
                                    <td><span class="badge {{ $comment->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $comment->status === 1 ? 'Approved' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $comment->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $comment->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        @if ($comment->status === 1)
                                            <a href="{{ route('admin.blogs.comments.update', $comment->id) }}"
                                                class="btn btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.blogs.comments.update', $comment->id) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-eye-slash"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.blogs.comments.destroy', $comment->id) }}"
                                            class="btn btn-danger delete-item">
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
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
