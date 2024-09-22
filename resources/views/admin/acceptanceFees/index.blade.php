@extends('admin.layouts.adminLayout')

@section('title', 'Acceptance Fee Manager')

@section('css')
    <style>
        .search-form {
            margin-bottom: 20px;
        }

        .action-buttons {
            white-space: nowrap;
        }
    </style>
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.acceptance_fees.index') }}" method="GET" class="search-form">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"
                                    placeholder="Search by student name or department" name="search"
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Student</th>
                                                <th>Department</th>
                                                <th>Transaction ID</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($acceptanceFees as $acceptance)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ Str::title($acceptance->user->full_name) }}</td>
                                                    <td>{{ $acceptance->department }}</td>
                                                    <td>{{ $acceptance->transaction_id }}</td>
                                                    <td>{{ $acceptance->paid_at ? $acceptance->paid_at->format('F d, Y H:i:s') : 'Not paid' }}
                                                    </td>
                                                    <td>
                                                        @if ($acceptance->status == 'paid')
                                                            <button class="btn btn-sm btn-success">PAID</button>
                                                        @elseif($acceptance->status == 'pending')
                                                            <button class="btn btn-sm btn-waring">PENDING</button>
                                                        @elseif($acceptance->status == 'expired')
                                                            <button class="btn btn-sm btn-danger">EXPIRED</button>
                                                        @endif
                                                        {{-- {{ $acceptance->status }} --}}
                                                    </td>
                                                    <td class="action-buttons">
                                                        <a href="{{ route('admin.acceptance_fee.show', $acceptance->id) }}"
                                                            class="btn btn-sm btn-info">View</a>
                                                        {{-- <form
                                                            action="{{ route('admin.acceptance_fee.destroy', $acceptance->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                                        </form> --}}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="alert alert-danger">No acceptance fees found</div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{-- {{ $acceptanceFees->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        // You can add any necessary JavaScript here
    </script>
@endsection
