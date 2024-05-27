@extends('admin.layouts.adminLayout')

@section('title', 'View Scholarship Details')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body shadow p-3">
                        <h3>{{ Str::title($scholarship->name) }}</h3>
                        <hr>
                        <p>{!! e($scholarship->description ?? 'N/A') !!}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-b">
                        more scholarship details
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



@section('js')

@endsection
