@extends('users\layouts')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users List</h5>

            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">Add New User</a>
        </div>
        <div class="card-body">


            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0 ?>
                        @forelse($users as $user)
                            <tr class="{{ $user->is_banned ? 'table-danger' : '' }}">
                                <td>{{ ++$i}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if($user->is_banned)

                                        <form action="{{ route('users.unban', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to unban this user?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger px-3 rounded-pill"
                                                title="Click to Unban">
                                                Banned <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('users.ban.form', $user) }}"
                                            class="btn btn-sm btn-success px-3 rounded-pill" title="Click to Ban"
                                            onclick="return confirm('Are you sure you want to proceed to ban this user?');">
                                            Active <i class="bi bi-check-circle"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    </>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            @if ($users->hasPages())
                <nav>
                    <ul class="pagination justify-content-center">
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif

        </div>
    </div>
@endsection