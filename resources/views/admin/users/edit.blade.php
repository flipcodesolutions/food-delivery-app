@extends('layout.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit User</h4>

        <a href="{{ route('admin.users.index') }}" class="btn btn-custom px-4">
            Back
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ $user->name }}"
                           class="form-control"
                           required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ $user->email }}"
                           class="form-control"
                           required>
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text"
                           name="phone"
                           value="{{ $user->phone }}"
                           class="form-control">
                </div>

                {{-- Password (optional) --}}
                <div class="mb-3">
                    <label class="form-label">Password (Leave blank if not changing)</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Enter new password">
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="restaurant" {{ $user->role == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                        <option value="delivery partner" {{ $user->role == 'delivery partner' ? 'selected' : '' }}>Delivery Partner</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-custom px-4">
                        Update User
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection