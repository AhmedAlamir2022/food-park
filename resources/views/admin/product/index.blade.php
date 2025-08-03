@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Products</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        Create new
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id="accordion">
                        <div class="accordion">
                            <div class="accordion-header collapsed bg-primary text-light p-3 " role="button"
                                data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                                <h4>Product Homepage Menu Section Titles..</h4>
                            </div>
                            <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                                <form action="{{ route('admin.product-title.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="">Top Title</label>
                                        <input type="text" class="form-control" name="product_top_title"
                                            value="{{ @$titles['product_top_title'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Main Title</label>
                                        <input type="text" class="form-control" name="product_main_title"
                                            value="{{ @$titles['product_main_title'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Sub Title</label>
                                        <input type="text" class="form-control" name="product_sub_title"
                                            value="{{ @$titles['product_sub_title'] }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                <th>Category</th>
                                <th>Show at home</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        @if ($product->thumb_image)
                                            <img width="60px" src="{{ asset($product->thumb_image) }}">
                                        @else
                                            <span>No image</span>
                                        @endif

                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $product->show_at_home === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $product->show_at_home === 1 ? 'Yes' : 'No' }}
                                        </span>

                                    </td>
                                    <td><span
                                            class="badge {{ $product->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $product->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $product->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $product->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.product.destroy', $product->id) }}"
                                            class="btn btn-danger delete-item ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <div class="btn-group dropleft">
                                            <button type="button" class="btn btn-dark dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropleft">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.product-gallery.show-index', $product->id) }}">Product
                                                    Gallery</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.product-size.show-index', $product->id) }}">Product
                                                    Variants</a>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
