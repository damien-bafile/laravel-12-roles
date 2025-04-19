@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Assign Users to Organization</h2>
        <form action="{{ route('organizations.assign_users') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="organization" class="form-label">Select Organization</label>
                <select name="organization_id" id="organization" class="form-control" required>
                    <option selected disabled>Choose an organization</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </select>
                @error('organization_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="user" class="form-label">Select User</label>
                <select name="user_id[]" id="user" class="form-control" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('user_id', [])) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assign to Organization</button>
        </form>
    </div>
@endsection
