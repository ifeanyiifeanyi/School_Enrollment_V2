@extends('admin.layouts.adminLayout')

@section('title', 'Faculty Details')

@section('css')

@endsection

@section('admin')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>@yield('title')</h1>
    </div>

    <div class="section-body">
      <a href="{{ route('admin.manage.faculty') }}" class="btn btn-outline-info mb-3"><i class="fas fa-arrow-left fa-4x"></i> Back</a>
      <div class="row">
        <div class="col-md-6">
          <div class="card shadow-lg">
            <div class="card-header">Faculty Details</div>
            <div class="card-body">
              <h3 class="text-muted"><u>{{ Str::title($faculty->name) }}</u></h3>
              {!! $faculty->description ?? 'Description not available at the moment..' !!}
            </div>
            <div class="card-footer">
              <footer class="">{{ $faculty->slug }}</footer>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-header">Associated Departments</div>
            <div class="card-body">
              <ul>
                @forelse ($faculty->departments as $department)
                <li><a href="" class="link text-muted">{{ Str::title($department->name) }}</a></li>
                @empty
                <li><a href="#!" class="link text-muted text-danger">Not available !</a></li>                  
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection



@section('js')

@endsection