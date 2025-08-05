@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Testimonials</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light p-3 " role="button"
                            data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                            <h4>Testimonial Section Titles..</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{ route('admin.testimonial-title-update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="testimonial_top_title"
                                        value="{{ @$titles['testimonial_top_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="testimonial_main_title"
                                        value="{{ @$titles['testimonial_main_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="testimonial_sub_title"
                                        value="{{ @$titles['testimonial_sub_title'] }}">
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
                <h4>All Testimonials</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary">
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
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Show At Home</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <img width="100px" src="{{ asset($testimonial->image) }}" class="rounded-circle">
                                    </td>
                                    <td>{{ $testimonial->name }}</td>
                                    <td>{{ $testimonial->title }}</td>
                                    <td>{{ $testimonial->rating }}</td>
                                    <td>{{ $testimonial->review }}</td>
                                    <td><span class="badge {{ $testimonial->show_at_home === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $testimonial->show_at_home === 1 ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td><span class="badge {{ $testimonial->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $testimonial->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $testimonial->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>
                                        {{ $testimonial->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.testimonial.destroy', $testimonial->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No testimonials found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $testimonials->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
