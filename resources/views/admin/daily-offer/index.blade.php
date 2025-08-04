@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Offer</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light p-3 " role="button"
                            data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                            <h4>Daily Offer Section Titles..</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{ route('admin.daily-offer-title-update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="daily_offer_top_title"
                                        value="{{ @$titles['daily_offer_top_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="daily_offer_main_title"
                                        value="{{ @$titles['daily_offer_main_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="daily_offer_sub_title"
                                        value="{{ @$titles['daily_offer_sub_title'] }}">
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
                <h4>All Daily Offers</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.daily-offer.create') }}" class="btn btn-primary">
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
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($dailyOffers as $offer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img width="50px" src="{{ asset($offer->product->thumb_image) }}"
                                            alt="Product Image">
                                    </td>
                                    <td>{{ $offer->product->name }}</td>
                                    <td><span class="badge {{ $offer->status === 1 ? 'badge-primary' : 'badge-danger' }}">
                                            {{ $offer->status === 1 ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $offer->created_at->format('M d,Y') }}
                                    </td>
                                    <td>
                                        {{ $offer->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.daily-offer.edit', $offer->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.daily-offer.destroy', $offer->id) }}"
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
                    {{ $dailyOffers->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
