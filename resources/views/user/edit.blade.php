@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-start">{{ __('Full Name') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="rfid" class="col-md-4 col-form-label text-md-start">{{ __('RFID') }}</label>
            <div class="col-md-6">
                <input id="rfid" type="text" class="form-control @error('rfid') is-invalid @enderror" name="rfid"
                    value="{{ old('rfid', $user->rfid) }}" required autocomplete="rfid">
                @error('rfid')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="no_hp" class="col-md-4 col-form-label text-md-start">{{ __('Phone number') }}</label>
            <div class="col-md-6">
                <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror"
                    name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required autocomplete="no_hp">
                @error('no_hp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-start">{{ __('Password') }}</label>
            <div class="col-md-6 input-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('password')">
                    <i id="password-toggle-icon" class="far fa-eye"></i>
                </button>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="role" class="col-md-4 col-form-label text-md-start">{{ __('Register as') }}</label>
            <div class="col-md-6">
                <select name="role" id="role" class="form-control select2" required>
                    <option value="pengguna" {{ old('role', $user->role) === 'pengguna' ? 'selected' : '' }}>User</option>
                    <option value="pengelola" {{ old('role', $user->role) === 'pengelola' ? 'selected' : '' }}>Canteen
                    </option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save Change') }}
                </button>
            </div>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var passwordToggleIcon = document.getElementById('password-toggle-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggleIcon.className = 'far fa-eye-slash';
            } else {
                passwordField.type = 'password';
                passwordToggleIcon.className = 'far fa-eye';
            }
        }
    </script>
@endsection
