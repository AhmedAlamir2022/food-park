<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
</div>
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Clients Management</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create New Client</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.user-management.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="" class="form-control">
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</section>
@endsection
