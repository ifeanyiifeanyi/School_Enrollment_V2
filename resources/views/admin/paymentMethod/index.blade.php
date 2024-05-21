@extends('admin.layouts.adminLayout')

@section('title', 'Payment Method Dashboard')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="p-2 mx-auto shadow col-md-6 card col-sm-12">

                        <form method="POST" action="{{ isset($paymentMethod) ? route('admin.payment.update', $paymentMethod->id) : route('admin.payment.store') }}" enctype="multipart/form-data">
                            @csrf
                            @isset($paymentMethod)
                                @method('PATCH')
                            @endisset

                            @isset($paymentMethod)
                                <input type="hidden" name="id" value="{{ $paymentMethod->id }}">
                            @endisset


                            <div class="form-group">
                                <label for="name">Payment Method:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Payment Method, Eg, Flutterwave"
                                    value="{{ old('name', isset($paymentMethod) ? $paymentMethod->name : '') }}"
                                    autocomplete="true">

                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="logo">Payment Logo:</label><br>
                            @isset($paymentMethod)
                                <img width="70px" src="{{ asset($paymentMethod->logo) }}" alt="" class="img-responsive">
                            @endisset
                                <input type="file" id="logo" name="logo" class="form-control" placeholder="Payment Method, Eg, Flutterwave" autocomplete="true">
                                @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="summernote-simple" placeholder="Payment method description .." name="description" id="description"
                                    class="form-control">{{ old('description', isset($paymentMethod) ? $paymentMethod->description : '') }}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                @if(isset($paymentMethod))
                                Update
                                @else
                                Create
                                @endif

                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="mx-auto col-md-6 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 20px">s/n</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                </tr>



                                @forelse ($paymentMethods as $pay)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="d-inline-block">
                                            {!! Str::title($pay->name) !!}
                                        </div>
                                        <div class="mb-3 ">
                                            <div class=""></div>
                                            <a href="{{route('admin.payment.manage', $pay->id) }}">Edit</a>
                                            <div class="bullet"></div>
                                            <a data-toggle="modal" data-target="#exampleModal" data-pay-id="{{ $pay->id }}" href="#" class="text-danger">Trash</a>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset($pay->logo) }}" alt="" class="img-circle" width="100">
                                    </td>
                                </tr>

                                @empty
                                <div class="text-center alert alert-danger"><b>Not available</b></div>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
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
             <a href="#" class="btn btn-danger" id="deletePayBtn">Delete</a>
          </div>
       </div>
    </div>
  </div>
@endsection



@section('js')
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var payId = button.data('pay-id');
       var modal = $(this);
       modal.find('#deletePayBtn').attr('href', '/admin/payment-method-del/' + payId);
    });
  </script>
@endsection
