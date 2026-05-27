@extends('layout.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Users</h4>

        <a href="{{ route('admin.users.create') }}" class="btn btn-dark btn-sm">
            + Create User
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">

    <div class="row g-2 align-items-center">

        {{-- Search Input --}}
        <div class="col-md-5">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search by name"
                   value="{{ request('search') }}">
        </div>

        {{-- Status Dropdown --}}
        <div class="col-md-3">
            <select name="status" class="form-select">

                <option value="">All Status</option>

                <option value="active"
                    {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="inactive"
                    {{ request('status') == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>

                <option value="pending"
                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

            </select>
        </div>

        {{-- Buttons --}}
        <div class="col-md-4">

            <div class="d-flex gap-2">

                {{-- Filter Button --}}
                <button type="submit"
                        class="btn btn-custom px-4">

                    Filter

                </button>

                {{-- Reset Button --}}
                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-dark px-4">

                    Reset

                </a>

            </div>

        </div>

    </div>

</form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>

                                {{-- Role Badge --}}
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @if($user->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($user->status == 'inactive')
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-action btn-edit">
                                            Edit
                                    </a>
                            @if($user->role!='admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirmDelete(event, this)">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-action btn-delete">
                                             Delete
                                    </button>

                                </form>
                                @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No users found
                                </td>
                            </tr>
                             
                        @endforelse

                       
                    </tbody>
                   
                </table>
                 
                <div class="mt-3 p-2 bg-white rounded shadow-sm">
                                 {{ $users->links() }}
                             </div>

            </div>

        </div>
    </div>

</div>

@endsection