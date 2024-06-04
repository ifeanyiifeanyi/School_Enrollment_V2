@extends('student.layouts.studentLayout')

@section('title', 'Application Manager')

@section('css')
    <style>
        .form-section {
            margin-bottom: 30px;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .action-buttons {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
        }

        .action-buttons button {
            margin-right: 10px;
        }

        /* Button Animation */
        .animate-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #17a2b8;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .animate-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('student')
    <section class="content">
        <div class="container-fluid">
            <!-- Button to open the modal with animation class -->
            <button type="button" class="animate-btn mb-3" data-toggle="modal" data-target="#instructionsModal">
                View Application Instructions
            </button>

            <!-- Instructions Modal -->
            <div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog" aria-labelledby="instructionsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="instructionsModalLabel">Application Instructions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <li class="text-danger">All fields marked with <q><span class="text-danger">*</span></q> are required.</li>
                                <li class="text-danger">Ensure you write your names correctly as you have it on <b>JAMB</b>.</li>
                                <li>Please provide accurate and up-to-date information to avoid delays or rejection of your application.</li>
                                <li>Have all necessary documents ready for upload in PDF or image format (max 2MB each).</li>
                                <li>Make sure to review your application thoroughly before submission.</li>
                                <li>Recent photograph (taken within the last 6 months)</li>
                                <li>Colored photograph with a white background</li>
                                <li>Full face, front view, with a neutral expression and both eyes open</li>
                                <li>Head covering is accepted for religious reasons, but the face must be clearly visible</li>
                                <li>Printed on high-quality photo paper</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            @livewire('student-application')

        </div>
        <!--/. container-fluid -->
    </section>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection
