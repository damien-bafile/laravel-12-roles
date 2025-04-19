@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Assign Roles to Users</h2>
        <form action="{{ route('users.assign_roles') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="user" class="form-label">Select User</label>
                <select name="user_id" id="user" class="form-control" required>
                    <option value="" selected disabled>Choose a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Assign Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="" selected disabled>Choose a role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="product_manager" {{ old('role') == 'product_manager' ? 'selected' : '' }}>Product Manager</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assign Role</button>
        </form>
    </div>
@endsection
