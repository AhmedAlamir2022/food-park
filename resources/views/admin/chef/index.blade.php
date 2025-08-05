@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light p-3 " role="button"
                            data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                            <h4>Chefs Section Titles..</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{ route('admin.chefs-title-update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="chef_top_title"
                                        value="{{ @$titles['chef_top_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="chef_main_title"
                                        value="{{ @$titles['chef_main_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="chef_sub_title"
                                        value="{{ @$titles['chef_sub_title'] }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Chefs</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.chefs.create') }}" class="btn btn-primary">
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
                                <th>Name</th>
                                <th>Title</th>
                                <th>Show At Home</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($chefs as $chef)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img width="60px" src="{{ asset($chef->image) }}" alt="Image"></td>
                                    <td>{{ $chef->name }}</td>
                                    <td>{{ $chef->title }}</td>
                                    <td><span
                                            class="badge {{ $chef->show_at_home === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $chef->show_at_home === 1 ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td><span class="badge {{ $chef->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $chef->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $chef->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $chef->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.chefs.edit', $chef->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.chefs.destroy', $chef->id) }}"
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
                    {{ $chefs->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
