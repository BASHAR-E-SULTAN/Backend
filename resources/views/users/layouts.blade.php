<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management Dashboard</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>


        <nav class="navbar navbar-dark bg-dark px-4">
            <a class="navbar-brand" href="#" style="padding-left: 100px;">User - Management - Dashboard </a>
        </nav>

        <div class="container my-4">

            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('users.index') }}" class="row g-3">

                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by name or email..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="index" class="form-control" placeholder="input index..."
                                value="{{ request('index') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            @yield('content')

        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bundle.min.js"></script>
    </body>

</html>