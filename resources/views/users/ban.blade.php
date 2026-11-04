@extends('users.layouts')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">


                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white mb-4 text-center">
                    <h3 class="fw-bold text-dark mb-1">{{ ucwords($c_user->name) }}</h3>
                    <p class="text-muted mb-0">{{ $c_user->email }}</p>



                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h4 class="fw-bold text-danger mb-3">Ban Account Reason</h4>

                        <form action="{{ route('users.ban', $c_user) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="ban_reason" class="form-label fw-semibold">Reason for Ban</label>
                                <textarea class="form-control @error('ban_reason') is-invalid @enderror" id="ban_reason"
                                    name="ban_reason" rows="4"
                                    placeholder="Enter the reason why this user is being banned..."
                                    required>{{ old('ban_reason') }}</textarea>
                                @error('ban_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Cancel</a>
                                <button type="submit" class="btn btn-danger px-4">Confirm Ban</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
@endsection