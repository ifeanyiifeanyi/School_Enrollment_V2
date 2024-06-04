@extends('student.layouts.studentLayout')

@section('title', "Application Manager")

@section('css')
<style>
    .instructions {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .instructions li {
        margin-bottom: 10px;
    }

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
</style>
@endsection

@section('student')
<section class="content">
    <div class="container-fluid">
        <div class="instructions">
            <ul>
                <li class="text-danger">All fields marked with <q><span class="text-danger">*</span></q> are required.</li>
                <li class="text-danger">Ensure you write your names correctly as you have it on <b>JAMB</b>.</li>
                <li>Please provide accurate and up-to-date information to avoid delays or rejection of your application.</li>
                <li>Have all necessary documents ready for upload in PDF or image format (max 2MB each).</li>
                <li>Make sure to review your application thoroughly before submission.</li>
            </ul>
        </div>

        @livewire('student-application')

    </div>
    <!--/. container-fluid -->
</section>
@endsection

@section('js')
<script>
    function changeImg(input) {
        let preview = document.getElementById('previewImage');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
