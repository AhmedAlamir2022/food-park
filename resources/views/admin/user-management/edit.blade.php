@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Clients Management</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Client Details</h4>

        </div>
        <div class="card-body">
            <form action="{{ route('admin.user-management.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $client->email }}">
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

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection
{{--  --}}
