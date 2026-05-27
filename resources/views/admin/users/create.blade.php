@extends('layout.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Create User</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-custom px-4" style="background-color: #20c997">
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter name">
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
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Enter email">
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
                           value="{{ old('phone') }}"
                           class="form-control @error('phone') is-invalid @enderror"
                           placeholder="Enter phone number">
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
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="restaurant" {{ old('role') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                        <option value="delivery_partner" {{ old('role') == 'delivery_partner' ? 'selected' : '' }}>Delivery Partner</option>
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
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
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
                             Create User
                     </button>
                </div>
            </form>

        </div>
    </div>

</div>

@endsection