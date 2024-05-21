@extends('student.layouts.studentLayout')

@section('title', "Payment Manager")
@section('css')

@endsection

@section('student')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="callout callout-danger">
          <h5 class="text-danger"><i class="fas fa-info"></i> Important Notice for All Prospective Students</h5>
         <p class="text-muted">
          Please be advised that any student applications not completed within 2 weeks of initiation will be automatically cancelled. Ensure you finalize all aspects of your application promptly to secure your candidacy.
         </p>
        </div>


        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> {{ config('app.name') }}.
                <small class="float-right">Date: {{ now()->format('jS, F Y g:i A') }}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <img class="w-50 img-responsive img-fluid img-thumbnail"
                src="{{ Storage::url($user->student->passport_photo) }}" alt="">
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">

              <address>
                <strong>
                  {{ Str::title($user->first_name) }} {{ Str::title($user->last_name) }} {{
                  Str::title($user->other_names) }}
                </strong><br>
                {{ Str::title($user->student->current_residence_address) }} <br>
                {{ Str::title($user->student->permanent_residence_address) }} <br>
                Phone: {{ $user->student->phone }}<br>
                Email: {{ Str::lower($user->email) }}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Invoice # {{ $application->invoice_number }}</b><br>
              <br>
              <b>Application ID:</b> {{ $user->student->application_unique_number }}<br>
              <b>Payment Due:</b> <code>{{ now()->addDays(20)->format('jS, F Y g:i A') }}</code><br>
              <b>Deparment</b> <var>{{ $application->department->name }}</var>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>s/n</th>
                    <th>Payment For</th>
                    <th>Description</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Application Form</td>
                    <td>Application fee for department enrollment processing and confirmation.</td>
                    <td>N{{ number_format($siteSetting->form_price, 2, '.', ',') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-md-6 col-sm-12">
              <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Attention valued student, your immediate tuition payment is due to finalize your departmental
                enrollment. Ensure timely processing to secure your spot and access all educational resources. Prompt
                payment ensures uninterrupted access to our comprehensive academic services and facilities. Remember,
                your investment in education is the foundation for your future success.
              </p>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-12">
              <p class="lead">Amount Due <b>{{ now()->addDays(20)->format('jS, F Y g:i A') }}</b></p>

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>N{{ number_format($siteSetting->form_price, 2, '.', ',') }}</td>
                  </tr>
                  <tr>
                    <th>Tax (9.3%)</th>
                    <td>N0.0</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>N{{ number_format($siteSetting->form_price, 2, '.', ',') }}</td>
                  </tr>
                </table>
              </div>

              <form action="{{ route('student.payment.process') }}" method="POST">
                @csrf
                <div class="col-md-12">
                  <p class="lead">Payment Methods:</p>
                    <input type="hidden" name="amount" value="{{ $siteSetting->form_price }}">
                    @foreach ($paymentMethods as $pm)
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="payment_method_id" id="{{ $pm->id }}" value="{{ $pm->id }}">
                      <label class="form-check-label" for="{{ $pm->id }}">
                        <img src="{{ asset($pm->logo) }}" width="80" alt="{{ $pm->name }}"> {{ $pm->name }}
                      </label>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 mt-3 btn-group">
                  <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                </div>
              </form>

            </div>
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">


        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection


@section('js')

@endsection