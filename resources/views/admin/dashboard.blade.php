{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <div class="h1">Admin Dashboard</div>
    
</form>
</body>
</html> --}}

@extends('layout.app')
@section('content')
{{-- <form method="POST" action="{{ route('admin.logout') }}">
    @csrf
<button type="submit">Logout</button>
</form> --}}
 <div class="container-fluid mt-4">
            <div class="card shadow-sm">
                <div class="card-header card-dark text-white fw-bold">Business Profile</div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Business Name</label>
                                <input type="text" class="form-control" value="Home Clean Service" />
                            </div>
                            <div class="col-md-6">
                                <label>Address</label>
                                <input type="text" class="form-control" value="Ahmedabad" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Logo</label>
                                <input type="file" class="form-control" />
                                <small class="text-danger">* File size: Max 2MB</small>
                                <img src="https://via.placeholder.com/100" class="mt-2 border" alt="preview" />
                            </div>
                            <div class="col-md-6">
                                <label>KYC Process</label>
                                <select class="form-select">
                                    <option selected>yes</option>
                                    <option>no</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>About</label>
                                <textarea class="form-control">Shree</textarea>
                            </div>
                            <div class="col-md-6">
                                <label>City</label>
                                <select class="form-select">
                                    <option selected>Ahmedabad</option>
                                    <option>Surat</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        
      @endsection 



