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
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>
                           @error('name')
                           <div class="text-danger mt-1">
                               {{ $message }}
                           </div>
                           @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required>
                           @error('email')
                           <div class="text-danger mt-1">
                               {{ $message }}
                           </div>
                           @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror">
                           @error('phone')
                           <div class="text-danger mt-1">
                            {{ $message }}
                           </div>
                           @enderror 
                </div>

                {{-- Password (optional) --}}
                <div class="mb-3">
                    <label class="form-label">Password (Leave blank if not changing)</label>
                    <input type="password"
                           name="password"
                           {{-- value="{{ old('password', $user->password) }}" --}}
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter new password">
                           @error('password')
                           <div class="text-danger mt-1">
                               {{ $message }}
                           </div>
                           @enderror
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="restaurant" {{ old('role', $user->role) == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                        <option value="delivery partner" {{ old('role', $user->role) == 'delivery partner' ? 'selected' : '' }}>Delivery Partner</option>
                    </select>
                    @error('role')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
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