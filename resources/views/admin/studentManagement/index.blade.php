@extends('admin.layouts.adminLayout')

@section('title', 'Student Management')

@section('css')
    <style>
        table tr {
            border-bottom: 2px solid #ccc
        }
    </style>
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            z-index: 9999;
        }

        .notification.success {
            background-color: #28a745;
        }

        .notification.error {
            background-color: #dc3545;
        }

        .search-container {
            position: relative;
            width: 100%;
            margin: 20px 0;
            text-align: center
        }

        .search-input {
            width: 80%;
            padding: 15px 20px 15px 45px;
            font-size: 18px;
            line-height: 1.5;
            color: #333;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .search-input::placeholder {
            color: #6c757d;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 12%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>@yield('title')</h4>

                            </div>
                            <div class="search-container">
                                <input type="search" id="search" class="search-input" placeholder="Search Students...">
                                <i class="search-icon fas fa-search"></i>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="shadow card card-statistic-1">
                                                <div class="card-icon bg-primary">
                                                    <i class="fas fa-university"></i>
                                                </div>
                                                <div class="card-wrap">
                                                    <div class="card-header">
                                                        <h4>Registered Students</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        {{ $verifiedStudentsCount ?? 0 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="shadow card card-statistic-1">
                                                <div class="card-icon bg-info">
                                                    <i class="fas fa-graduation-cap""></i>
                                                </div>
                                                <div class="card-wrap">
                                                    <div class="card-header">
                                                        <h4>Active Applications</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        {{ $activeApplication ?? 0 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-left pb-1">
                                    <a href="{{ route('admin.export.allStudent') }}" class="shadow btn btn-primary"
                                        id="exportButton">Export to Excel</a>
                                </div>

                                <form id="bulk-action-form" method="POST"
                                    action="{{ route('admin.students.deleteMultiple') }}">
                                    @csrf
                                    <div class="float-right mb-3">
                                        <select class="form-control selectric"
                                            onchange="if (this.value) { this.form.submit(); }">
                                            <option value="">Action For Selected</option>
                                            <option value="delete">Delete Permanently</option>
                                        </select>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped" id="">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 10px !important">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup"
                                                                data-checkbox-role="dad" class="custom-control-input"
                                                                id="checkbox-all">
                                                            <label for="checkbox-all"
                                                                class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th style="width: 10px !important">sn</th>
                                                    <th style="">Student Name</th>
                                                    <th>Phone</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="studentTableBody">
                                                @forelse ($students as $student)
                                                    {{-- @dd($student->id) --}}
                                                    <tr>
                                                        <td>
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" name="selected_students[]"
                                                                    value="{{ $student->id }}" data-checkboxes="mygroup"
                                                                    class="custom-control-input"
                                                                    id="checkbox-{{ $student->id }}">
                                                                <label for="checkbox-{{ $student->id }}"
                                                                    class="custom-control-label">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="align-middle">
                                                            <a href="#" style="text-decoration:none;color:#444"
                                                                data-toggle="modal" data-target="#mailModal"
                                                                data-student-email="{{ $student->email }}">
                                                                {{ Str::title($student->full_name ?? 'N/A') }}

                                                                <br><code
                                                                    style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;color:goldenrod">{{ $student->student->application_unique_number ?? 'N/A' }}</code>

                                                            </a>
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $student->student->phone }}
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($student->applications->isNotEmpty())
                                                                <p>{{ $student->applications->first()->department_name ?? 'N/A' }}
                                                                </p>
                                                            @else
                                                                <p>N/A</p>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($student->applications->contains('payment_id', '!=', null))
                                                                <span style="background: teal !important"
                                                                    class="badge badge-success text-light">Active
                                                                    Application</span>
                                                            @else
                                                                <span class="badge badge-primary text-light">Application
                                                                    Incomplete</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle">
                                                            @if ($student->applications->contains('payment_id', '!=', null))
                                                                {{-- Payment exists, hide the delete button --}}
                                                            @else
                                                                {{-- Payment does not exist, show the delete button --}}
                                                                <a href="{{ route('admin.destroy.student', $student->nameSlug) }}"
                                                                    onclick="return confirm('Are you sure of this action?')"
                                                                    class="btn btn-danger btn-sm"><i
                                                                        class="fas fa-trash"></i></a>
                                                            @endif


                                                            <a href="{{ route('admin.show.student', $student->nameSlug) }}"
                                                                class="btn btn-sm btn-info">
                                                                <i class="fas fa-user"></i>
                                                            </a>
                                                            <a href="{{ route('admin.edit.student', $student->nameSlug) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-warning"
                                                                data-toggle="modal" data-target="#mailModal"
                                                                data-student-email="{{ $student->email }}">
                                                                <i class="fas fa-envelope"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- //delete modal --  --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle fa-3x"></i> Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are You Sure? <br> This action can not be undone. Do you want to continue?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-danger" id="deleteSingleStudent">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mail Modal -->
    <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="notification" class="mb-2 notification" style="display: none;"></div>

                <div class="modal-header">

                    <h5 class="modal-title" id="mailModalLabel">Send Mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="loader" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <p><span class=""> <i class="fas fa-spinner fa-spin fa-3x"></i> SENDING ... </span></p>

                        </div>
                    </div>
                    <form id="mailForm">
                        @csrf
                        <div class="form-group">
                            <label for="mailSubject">Subject</label>
                            <input type="text" class="form-control" id="mailSubject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="mailContent">Content</label>
                            <textarea class="form-control" id="mailContent" name="content" rows="5" required></textarea>
                        </div>
                        <input type="hidden" id="mailRecipient" name="recipient">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendMail">Send Mail</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                fetch_students(query);
            });

            function fetch_students(query = '') {
                $.ajax({
                    url: "{{ route('admin.students.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#studentTableBody').html(data);
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#mailModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var studentEmail = button.data('student-email');
                var modal = $(this);
                modal.find('#mailRecipient').val(studentEmail);
            });

            function showNotification(message, type) {
                var notification = $('#notification');
                notification.removeClass('success error');
                notification.addClass(type);
                notification.html(message);
                notification.fadeIn();
                setTimeout(function() {
                    notification.fadeOut();
                }, 5000); // Adjust the duration (in milliseconds) as needed
            }




            $('#sendMail').click(function() {
                var subject = $('#mailSubject').val();
                var content = $('#mailContent').val();
                var recipient = $('#mailRecipient').val();

                // Show the loader
                $('#loader').show();

                // AJAX request to send the mail
                $.ajax({
                    url: '{{ route('admin.send.mail') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        subject: subject,
                        content: content,
                        recipient: recipient
                    },
                    success: function(response) {
                        // Hide the loader
                        $('#loader').hide();

                        showNotification(response.message, 'success');
                        $('#mailModal').modal('hide');
                        $('#mailForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Hide the loader
                        $('#loader').hide();

                        if (xhr.status === 422) {
                            // Display validation errors
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value.join(' ') + '<br>';
                            });
                            showNotification(errorMessages, 'error');
                        } else {
                            showNotification('Error sending mail. Please try again later.',
                                'error');
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
    <script>
        // -- modal confirm for single delete
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var studentSlug = button.data('student-slug');
            var modal = $(this);
            modal.find('#deleteSingleStudent').attr('href', '/admin/delete-student/' + studentSlug);
        });
    </script>

    <script>
        // -- checkbox for multi delete
        document.addEventListener('DOMContentLoaded', function() {
            const masterCheckbox = document.getElementById('checkbox-all');
            const checkboxes = document.querySelectorAll('input[name="selected_students[]"]');

            masterCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
    </script>

@endsection



@section('js')


@endsection
