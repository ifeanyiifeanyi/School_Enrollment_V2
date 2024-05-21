@extends('admin.layouts.adminLayout')

@section('title', 'Active Applications')

@section('css')

@endsection

@section('admin')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>@yield('title')</h1>
    </div>

    <div class="section-body">

      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <div class="float-left">
            <form action="{{ route('admin.student.applications.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="exampleInputFile">Import File</label>
                <div class="container">
                  @error('file')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="custom-file">
                  <input type="file" name="file" class="form-control w-100" id="exampleInputFile">
                  <button type="submit" class="btn btn-primary w-100 mt-2">Import</button>
                </div>
              </div>
            </form>
          </div>
          <div class="clearfix mb-3"></div>

          <div class="float-left">
            <form id="departmentForm" action="{{ route('admin.student.application') }}" method="GET">
              <select class="form-control selectric" name="department_id"
                onchange="updateExportLink(); this.form.submit();">
                <option value="">Select by Department (Show All)</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}" {{ request('department_id')==$department->id ? 'selected' : '' }}>
                  {{ Str::title($department->name) }}
                </option>
                @endforeach
              </select>
            </form>
          </div>

            <div class="float-right pb-1">
                <a href="{{ route('admin.student.applications.export') }}" class="btn btn-success"
                  id="exportButton">Export to Excel</a>
            </div>
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 20px">s/n</th>
                  <th style="width: auto !important">Student</th>
                  <th>Application No.</th>
                  <th>Department</th>
                  <th>Exam Score</th>
                  <th>Admission</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($applications as $index => $ap)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $ap->user->full_name }}</td>
                  <td>{{ $ap->user->student->application_unique_number }}</td>
                  <td>{{ $ap->department->name }}</td>
                  <td>{{ $ap->user->student->exam_score ?? 'Loading ...' }}</td>
                  <td>
                    @if ($ap->admission_status == "pending")
                    <span class="badge bg-warning text-light">Pending <i class="fa fa-spinner fa-spin"></i></span>
                    @elseif ($ap->admission_status == "denied")
                    <span class="badge bg-danger text-light">Denied <i class="fa fa-times"></i></span>
                    @elseif ($ap->admission_status == "approved")
                    <span class="badge bg-success text-light">Approved <i class="fa fa-check"></i></span>
                    @endif
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
                  <th>Application No.</th>
                  <th>Department</th>
                  <th>Exam Score</th>
                  <th>Admission Status</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="paginate text-center">
            {{ $applications->links() }}
          </div>
        </div>
        <!-- /.card-body -->
      </div>

    </div>
</div>
</section>
</div>
@endsection



@section('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.querySelector('.selectric');
    selectElement.addEventListener('change', function (event) {
      const form = document.getElementById('departmentForm');
      form.submit();
    });
  });
</script>

<script>
  function updateExportLink() {
    const departmentId = document.querySelector('[name="department_id"]').value;
    const exportButton = document.getElementById('exportButton');
    let url = '{{ route("admin.student.applications.export") }}';
    url += departmentId ? '?department_id=' + departmentId : '';
    exportButton.href = url;
  }
  document.addEventListener('DOMContentLoaded', function() {
    updateExportLink(); // Update on load in case there's an initial department selected
  });
</script>

@endsection