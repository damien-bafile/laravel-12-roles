@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Organization</h2>
        <form action="{{ route('organizations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Organization Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Organization</button>
        </form>
    </div>
@endsection
