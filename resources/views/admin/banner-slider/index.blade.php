@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Banner Slider</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Banner Slider</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.banner-slider.create') }}" class="btn btn-primary">
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
                                <th>Banner</th>
                                <th>Title</th>
                                <th>Url</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($bannerSliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img width="100px" src="{{ asset($slider->banner) }}"
                                            alt="Banner Image">
                                    </td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->url }}</td>
                                    <td>
                                        {{ $slider->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $slider->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banner-slider.edit', $slider->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.banner-slider.destroy', $slider->id) }}"
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
                    {{ $bannerSliders->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
