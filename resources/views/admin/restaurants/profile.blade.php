@extends('layout.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Restaurant Profile</h3>

    {{-- <div class="card shadow-sm">
        <div class="card-body">

            <h4>{{ $restaurant->name }}</h4>
            <p>{{ $restaurant->email }}</p>
            <p>{{ $restaurant->phone }}</p>

            <hr>

            @if($restaurant->restaurantProfile)
                <h5>Restaurant Details</h5>

                <p><strong>Name:</strong> {{ $restaurant->restaurantProfile->restaurant_name }}</p>
                <p><strong>Detail:</strong> {{ $restaurant->restaurantProfile->detail }}</p>
                <p><strong>Opening Time:</strong> {{ $restaurant->restaurantProfile->opening_time }}</p>
                <p><strong>Closing Time:</strong> {{ $restaurant->restaurantProfile->closing_time }}</p>

                @if($restaurant->restaurantProfile->logo)
                    <img src="{{ asset('storage/'.$restaurant->restaurantProfile->logo) }}"
                         width="120">
                @endif
            @else
                <p class="text-danger">No restaurant profile found</p>
            @endif

        </div>
    </div> --}}
            @if($restaurant->restaurantProfile)
    {{-- <div class="card mb-3">
  <img src="{{asset($restaurant->restaurantProfile->logo)}}" class="card-img-top" alt="..."  style="height: 250px; width:100px object-fit: cover;">
  <div class="card-body">
    <h5 class="card-title"> {{ $restaurant->restaurantProfile->restaurant_name }}</h5>
    <p class="card-text"> {{ $restaurant->restaurantProfile->detail }}</p>
    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
  </div>
</div> --}}

<div class="card mb-3" style="max-width: 1200px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{{ asset($restaurant->restaurantProfile->logo) }}" class="img-fluid rounded-start" alt="..." style="height:400px;width:100%;object-fit: cover;">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title" style="margin-top:50px; font-size:2rem; margin-left:20px;">{{ $restaurant->restaurantProfile->restaurant_name }}</h5>
        <p class="card-text" style="margin-left:20px; margin-top:20px; font-size:1.2rem;"> {{ $restaurant->restaurantProfile->detail }}</p>
        <p class="card-text"><small class="text-muted" style="margin-left:20px; margin-top:20px; font-size:1.1rem; font-color:rgb(0,128,0);">{{ ucfirst($restaurant->status) }}</small></p>
      </div>
    </div>
  </div>
</div>

<div class="card-group" style="height: 350px;">
  <div class="card">
    {{-- <img src="..." class="card-img-top" alt="..."> --}}
    <div class="card-body">
      <h5 class="card-title">Restaurant Details</h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    </div>
    {{-- <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div> --}}
  </div>
  <div class="card">
    {{-- <img src="..." class="card-img-top" alt="..."> --}}
    <div class="card-body">
      <h5 class="card-title">Categories</h5>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
    </div>
    {{-- <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div> --}}
  </div>
  <div class="card">
    {{-- <img src="..." class="card-img-top" alt="..."> --}}
    <div class="card-body">
      <h5 class="card-title">Menus</h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
    </div>
    {{-- <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div> --}}
  </div>
</div>


</div>

@endif
@endsection