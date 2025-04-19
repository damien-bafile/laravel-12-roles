@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Organization</h2>
        <form action="{{ route('organizations.update', $organization->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Organization Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $organization->name) }}" required>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $organization->description) }}</textarea>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Organization</button>
        </form>
    </div>
@endsection
