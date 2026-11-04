@extends('users.layouts')

@section('content')
    <div class="container text-center py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-5 border-0">
                    <h3 class="mb-3 text-secondary" style="padding-bottom: 120px;">Oops! Page Not Found</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-primary px-4">
                        Back to Users List
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection