@extends('layout.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">CMS of 
                {{ $cms->title }}</h4>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.cms.update', $cms->slug) }}" method="POST">
                @csrf
                @method('PUT')
    
                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $cms->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                    @error('title')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" value="" class="form-control @error('description') is-invalid @enderror" placeholder="Enter detail">{{ old('description', $cms->description) }}</textarea>
                    @error('description')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

               
                {{-- Submit --}}
                <div class="text-end">
                     <button type="submit" class="btn btn-custom px-4">
                             Update CMS
                     </button>
                </div>
            </form>


            {{-- Pagination --}}
            
        </div>
    </div>

</div>

@endsection