@extends('layout.app')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Restaurant List</h4>
    </div>

    {{-- Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
             <form method="GET" action="{{ route('admin.restaurants.index') }}" class="mb-3">

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
                         <a href="{{ route('admin.restaurants.index') }}"
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

                    {{-- Table Head --}}
                    <thead class="table-dark">
                        <tr>
                           
                            <th>Restaurant Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody>
                        @forelse($restaurants as $restaurant)
                            <tr>
                                {{-- Name --}}
                                <td>
                                    <div class="fw-semibold">
                                        {{ $restaurant->name }}
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td>{{ $restaurant->email }}</td>

                                {{-- Phone --}}
                                <td>{{ $restaurant->phone }}</td>

                                {{-- Status --}}
                                <td>

                                    @if($restaurant->status == 'active')

                                        <span class="badge bg-success px-3 py-2">
                                            Active
                                        </span>

                                    @elseif($restaurant->status == 'inactive')

                                        <span class="badge bg-danger px-3 py-2">
                                            Inactive
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                {{-- View Profile --}}
                                <td>                           

                            <div class="dropdown">

                                <button class="btn btn-sm btn-dark dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">
                                        Actions

                                </button>

                            <ul class="dropdown-menu">
                                    {{-- View Profile --}}
                                    <li>
                                       <a class="dropdown-item"
                                          href="{{ route('admin.restaurants.index', $restaurant->id) }}">
                                               👁 View Profile

                                       </a>
                                   </li>

                                    {{-- View Orders --}}
                                    <li>
                                        <a class="dropdown-item">
                                           {{-- href="{{ route('admin.restaurants.orders', $restaurant->id) }}"> --}}
                                               📦 View Orders
                                                   </a>
                                    </li>

                                     {{-- View Menu --}}
                                    <li>
                                        <a class="dropdown-item">
                                            {{-- href="{{ route('admin.restaurants.menu', $restaurant->id) }}"> --}}
                                                🍔 View Menu
                                        </a>
                                    </li>

                             </ul>
                            </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No Restaurants Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $restaurants->links() }}
            </div>

        </div>
    </div>

</div>

@endsection


{{-- Custom CSS --}}
<style>

    /* Table */
    .table td,
    .table th {
        vertical-align: middle;
    }

    /* View Button */
    .btn-view {
        background-color: #20c997;
        color: #fff;
        border-radius: 8px;
        padding: 7px 12px;
        transition: 0.3s ease;
    }

    .btn-view:hover {
        background-color: #18a77b;
        color: #fff;
    }

    .btn-view:focus {
        box-shadow: none;
    }

</style>