@extends('admin.layouts.adminLayout')

@section('title', 'Send Notifications')

@section('css')
@endsection

@section('admin')
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <p class="section-lead">
                    Notification Manager
                </p>

                <div id="output-status"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.examNotification.nav')

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <div class="container-fluid">
                            <div class="mx-auto">
                                @forelse ($examNotifications as $examNotification)
                                    <div class="shadow card">
                                        <div class="card-body">
                                            <p>{{ $loop->iteration }}</p>
                                            <p class="mb-2 text-muted">Notification For: <span class="text-primary">
                                                    {{ Str::title($examNotification->department->name ?? 'Loading ...') }}</span>
                                            </p>
                                            <button class="shadow btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#notificationModal"
                                                data-id="{{ $examNotification->id }}">
                                                <i class="fas fa-book-reader"></i>
                                            </button>
                                            <a onclick="return confirm('Are you sure of this delete action ?')" href="{{ route('admin.showNotification.destroy', $examNotification->id) }}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-danger">No Notification At The Moment</div>
                                @endforelse
                                <div class="card-body">
                                    {{-- {{ $examNotifications->links() }} --}}
                                    {!! $examNotifications->links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Department:</strong> <span id="notificationDepartment"></span></p>
                <p><strong>Exam Date:</strong> <span id="notificationExamDate"></span></p>
                <p><strong>Venue:</strong> <span id="notificationVenue"></span></p>
                <p><strong>Requirements:</strong> <br> <span id="notificationRequirements"></span></p>
            </div>
        </div>
    </div>
</div>

@endsection



@section('js')
    <script>
        $(document).ready(function() {
            $('#notificationModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var notificationId = button.data('id');
                var modal = $(this);
                $.ajax({
                    url: 'exam-notification/' + notificationId,
                    method: 'GET',
                    beforeSend: function() {
                        modal.find('#notificationContent').text('Loading...');
                    },
                    success: function(response) {
                        modal.find('#notificationDepartment').text(response.department);
                        modal.find('#notificationExamDate').text(response.exam_date);
                        modal.find('#notificationVenue').text(response.venue);
                        modal.find('#notificationRequirements').html(response.requirements);
                    },
                    error: function() {
                        modal.find('#notificationContent').text(
                            'An error occurred while loading the notification.');
                    }
                });
            });
        });
    </script>
@endsection
