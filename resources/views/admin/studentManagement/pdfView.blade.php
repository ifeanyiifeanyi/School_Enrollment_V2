@extends('admin.layouts.pdf_layout')

@section('title', "Student List")


@section('pdf_view')
<table id="example1" class="table table-bordered table-striped">
    <caption>@yield('title')</caption>
    <thead>
        <tr>
            <th style="width: 20px">s/n</th>
            <th style="width: auto !important">Student</th>
            <th>profile</th>
            <th>Transactions</th>
            <th>Department</th>
            <th>Exam Venue</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($applications as $ap)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                {{ $ap->user->full_name }} <br>
                <code>{{ $ap->user->student->application_unique_number }}</code>
            </td>
            <td>
                <img src="data:image/png;base64,{{ base64_encode(Storage::get($ap->user->student->passport_photo)) }}" alt="" class="img-fluid" width="150px" height="120px">

            </td>
            <td>
                <small><b>Invoice: </b> {{ $ap->invoice_number }}</small> <br>
                <small><b>Transact: </b> {{ $ap->payment->transaction_id }}</small>
            </td>
            <td>{{ $ap->department->name }}</td>
            <td>
                <p><b>Venue: </b>{{ $ap->department->exam_managers->venue ?? 'null' }}</p>
                <p><b>Date: </b>{{ $ap->department->exam_managers->date_time ?? 'null' }}</p>
            </td>
        </tr>
        @empty
        <div class="alert alert-danger text-center">Not available</div>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th>s/n</th>
            <th>Student</th>
            <th>Profile.</th>
            <th>Transactions</th>
            <th>Department</th>
            <th>Exam Venue</th>
        </tr>
    </tfoot>
</table>
@endsection