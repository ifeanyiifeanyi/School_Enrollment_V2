@extends('admin.layouts.adminLayout')

@section('title', 'Student Information')

@section('css')
<style>
  .card {
  margin-bottom: 1.5rem;
}

.card-header {
  background-color: #f8f9fa;
}

.list-group-item {
  border-left: 0;
  border-right: 0;
}

.list-group-item:first-child {
  border-top: 0;
}

.list-group-item:last-child {
  border-bottom: 0;
}

.badge {
  font-weight: normal;
}
</style>
@endsection

@section('admin')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ Str::title($student->full_name) }}</h1> <br>
    </div>
    <div class="container">
      <h4 class="text-muted">Application No: <code>{{ $student->student->application_unique_number ?? 'Yet To Apply!!' }}</code></h4>
    </div>
    <div class="section-body">
      {{-- @dd($student) --}}
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-striped table-responsive">
              <thead class="">
                <tr>
                  <th colspan="2" class="text-center">
                    <p><img alt="image" src="{{ empty($student->student->passport_photo) ? asset('admin/assets/img/avatar/avatar-5.png') : 
                      Storage::url($student->student->passport_photo) }}" class="mt-3 img-thumbnail" style="width: 250px !important; height:250px !important" data-toggle="title" title="{{ $student->full_name }}"></p>
                    <div class="d-inline-block">
                      <p>{{ Str::title($student->student->nationality ?? "N/A")  }}</p>
                      <p class="text-muted">
                        @if ($student->student->nationality == "Nigeria")
                          <b>NIN: </b> {{ $student->student->nin  ?? "N/A"}}
                        @endif
                      </p>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>Email Address</th>
                  <td>{{ Str::lower($student->email ?? "N/A") }}</td>
                </tr>
                <tr>
                  <th>Phone Number</th>
                  <td>{{ $student->student->phone ?? "N/A" }}</td>
                </tr>
                <tr>
                  <th>Gender</th>
                  <td>{{ Str::upper($student->student->gender ?? "N/A") }}</td>
                </tr>
                <tr>
                  <th>Religion</th>
                  <td>{{ $student->student->religion ?? "N/A"}}</td>
                </tr>
                <tr>
                  <th>Date of Birth</th>
                  <td>{{ $student->student->dob ?? "N/A"}}</td>
                </tr>
                <tr>
                  <tr>
                    <th>Genotype</th>
                    <th>Blood Group</th>
                  </tr>
                  <tr>
                    <td>{{ $student->student->genotype ?? 'N/A' }}</td>
                    <td>{{ $student->student->blood_group ?? 'N/A' }}</td>
                  </tr>
                </tr>
                <tr>
                  <th>Secondary School</th>
                  <td>
                    <p><b>School: </b>{{ Str::title($student->student->secondary_school_attended ?? 'N/A') }}</p>
                    <p><b>Graduated: </b> {{ $student->student->secondary_school_graduation_year ?? "N/A" }}</p>
                    <p><b>Cert: </b>{{ Str::upper($student->student->secondary_school_certificate_type ?? "N/A") }}</p>
                  </td>
                </tr>
                <tr>
                  <tr>
                    <th>Jamb Reg No</th>
                    <th>Jamb Score</th>
                  </tr>
                  <tr>
                    <td>{{ $student->student->jamb_reg_no ?? 'N/A' }}</td>
                    <td>{{ $student->student->jamb_score ?? 'N/A' }}</td>
                  </tr>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="container">
            <h1 class="text-center mb-4">SSCE Results</h1>
            @if ($student && $student->student && $student->student->olevel_exams)
              @php
                $olevel_exams = json_decode($student->student->olevel_exams, true);
              @endphp
          
              @if (isset($olevel_exams['sittings']) && $olevel_exams['sittings'] > 0)
                <div class="row">
                  <div class="col-md-6">
                    @for ($i = 1; $i <= $olevel_exams['sittings']; $i++)
                      <div class="card mb-4">
                        <div class="card-header">
                          <h5 class="mb-0">Sitting {{ $i }}</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group">
                            @foreach ($olevel_exams['subjects']['sitting_' . $i] as $subject)
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $subject['subject'] }}
                                <span class="badge badge-primary badge-pill">{{ $subject['score'] }}</span>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    @endfor
                  </div>
                  <div class="col-md-6">
                    @if (isset($olevel_exams['exam_boards']))
                      <div class="card">
                        <div class="card-header">
                          <h5 class="mb-0">Exam Boards</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group">
                            @if ($olevel_exams['sittings'] == 1)
                              @foreach ($olevel_exams['exam_boards'] as $key => $value)
                                @if ($key === 'exam_board_1')
                                  <li class="list-group-item">{{ Str::upper($key) }}: {{ Str::upper($value) }}</li>
                                @endif
                              @endforeach
                            @else
                              @foreach ($olevel_exams['exam_boards'] as $key => $value)
                                <li class="list-group-item">{{ Str::upper($key) }}: {{ Str::upper($value) }}</li>
                              @endforeach
                            @endif
                          </ul>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              @else
                <p>No SSCE results found for this student.</p>
              @endif
            @else
              <p>No SSCE results found for this student.</p>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            
            <div class="card-body">
              <p><b>Permanent Address: </b> <blockquote>{{ $student->student->permanent_residence_address ?? "N/A"}}</blockquote></p>
              <p><b>Current Address: </b> <blockquote>{{ $student->student->current_residence_address ?? "N/A"}}</blockquote></p>
              <p><b>LGA, STATE, COUNTRY: </b> <blockquote>{{ $student->student->lga_origin ?? "N/A" }}, {{ $student->student->state_of_origin ?? "N/A" }}, {{ $student->student->country_of_origin ?? "N/A" }}</blockquote></p>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <p><b>Guardian Name: </b> <blockquote>{{ $student->student->guardian_name ?? "N/A" }}</blockquote></p>
              <p><b>Guardian Phone Number: </b> <blockquote>{{ $student->student->guardian_phone_number ?? "N/A" }}</blockquote></p>
              <p><b>Guardian Address: </b> <blockquote>{{ $student->student->guardian_address ?? "N/A" }}</blockquote></p>
            </div>
          </div>


          <div class="section">
            <div class="container">
              <h3 class="text-center mb-4">Student Documents</h3>
              @foreach ($documents as $label => $doc)
                <div class="mb-3 card card-body">
                  <strong>{{ Str::title(str_replace('_', ' ', $label)) }}:</strong>
                  @if ($doc['exists'])
                    @if ($doc['isPdf'])
                      <a href="{{ $doc['filePath'] }}" class="btn btn-primary mt-2" target="_blank">Open PDF in New Tab</a>
                    @else
                      <button class="btn btn-success mt-2" onclick="showImage('{{ $doc['filePath'] }}')">View Image</button>
                      <!-- Image view modal placeholder -->
                      <div id="imageModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1050;" onclick="this.style.display='none'">
                        <img src="{{ $doc['filePath'] }}" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);max-height:90%;max-width:90%;">
                      </div>
                    @endif
                  @else
                    <span class="text-danger">Not Available</span>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
          
          {{-- <script>
          function showImage(src) {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'block';
            modal.querySelector('img').src = src;
          }
          </script> --}}
          
          
          
        </div>

      </div>
    </div>
  </section>
</div>
@endsection



@section('js')
<script>
  function showImage(src) {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'block';
    modal.querySelector('img').src = src;
  }
  </script>
@endsection