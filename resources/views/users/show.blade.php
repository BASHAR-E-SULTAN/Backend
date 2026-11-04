@extends('users.layouts')
@section('content')




    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg border-0 rounded-4 p-4 col-md-6 bg-white">


            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-0">{{ ucwords($user->name) }}</h3>
            </div>

            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="fw-semibold text-secondary">Email:</span>
                    <span class="text-dark">{{ $user->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="fw-semibold text-secondary">Phone:</span>
                    <span class="text-dark">{{ $user->phone }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <span class="fw-semibold text-secondary">Status:</span>
                    <span>
                        @if($user->is_banned)
                            <span class="badge bg-danger px-3 py-2">Banned</span>
                            <br>
                        @else
                            <span class="badge bg-success px-3 py-2">Active</span>
                        @endif
                        @if ($user->is_banned)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="fw-semibold text-secondary">Banned Reason:</span>
                                <span class="text-dark">{{ $user->ban_reason }}</span>
                            </li>
                        @endif
                @if ($user->is_banned)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="fw-semibold text-secondary">banned At:</span>
                        <span class="text-dark">{{ $user->banned_at }}</span>
                    </li>
                @endif
                </span>
                </li>


            </ul>

            <div class="text-center">
                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill w-100">
                    <i class="bi bi-arrow-left"></i> Back to Users List
                </a>
            </div>

        </div>
    </div>

@endsection