<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $user->full_name }}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="{{ Storage::url($user->student->passport_photo) }}" type="image/x-icon">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-7 mx-auto">
                <section class="content">
                    {{-- @dd($user) --}}
                        <div class="container">
                            <div class="card shadow mt-5">
                                <div class="img-responsive text-center p-3">
                                    <img src="{{ Storage::url($user->student->passport_photo) }}" alt="Passport Photo" class="img-fluid" width="120px">
                                </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>Full Name:</strong> {{ $user->full_name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Department: </strong>
                                    {{ $user->applications->first()->department->name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Transaction NO: </strong>
                                    {{ $user->applications->first()->payment->transaction_id }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Application Number: </strong> 
                                    {{ $user->student->application_unique_number }} 
                                </li>
                                <li class="list-group-item">
                                    <strong>Invoice Number:</strong> {{ $user->applications->first()->invoice_number }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Application Date:</strong> {{ $user->applications->first()->created_at->format('jS F, Y') }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Application Status: </strong>
                                    {{ $user->applications->first()->admission_status }}
                                </li>
                                <li class="list-group-item"></li>
                            </ul>
                            </div>
                        </div>
                    </section>
            </div>
        </div>
    </div>
</body>
</html>