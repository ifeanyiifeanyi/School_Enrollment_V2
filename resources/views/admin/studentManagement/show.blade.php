@extends('admin.layouts.adminLayout')

@section('title', 'Student Information')

@section('css')
<style>
  body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
  }

  .card {
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }

  .card-header {
    background: linear-gradient(to right, #FF512F, #DD2476);
    color: white;
    padding: 20px;
    font-size: 24px;
    font-weight: bold;
    border-radius: 20px 20px 0 0;
  }

  .card-body {
    padding: 30px;
  }

  .img-thumbnail {
    border-radius: 50%;
    border: 5px solid #FF512F;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .badge {
    font-weight: normal;
    background-color: #FF512F;
    color: white;
    border-radius: 20px;
    padding: 5px 15px;
  }

  h1 {
    font-size: 36px;
    font-weight: bold;
    color: #DD2476;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  }

  h4 {
    color: #FF512F;
    font-weight: bold;
  }

  .list-group-item {
    border: none;
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
  }

  .list-group-item:last-child {
    margin-bottom: 0;
  }

  .list-group-item .badge {
    font-size: 16px;
  }

  blockquote {
    background: linear-gradient(to right, rgba(255, 81, 47, 0.1), rgba(221, 36, 118, 0.1));
    border-left: 10px solid #FF512F;
    margin: 1.5em 10px;
    padding: 0.5em 10px;
    border-radius: 10px;
    font-style: italic;
    color: #666;
  }

  blockquote p {
    display: inline;
  }

  .btn-primary,
  .btn-success {
    background: linear-gradient(to right, #FF512F, #DD2476);
    border: none;
    border-radius: 30px;
    padding: 12px 30px;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .btn-primary:hover,
  .btn-success:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  #imageModal img {
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  }
</style>
@endsection

@section('admin')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>{{ Str::title($student->full_name) }}</h1>
      <br>
    </div>
    <div class="container">
      <h4>Application No: <code>{{ $student->student->application_unique_number ?? 'Yet To Apply!!' }}</code></h4>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-md-6">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th colspan="2" class="text-center">
                    <p>
                      <img alt="image" src="{{ empty($student->student->passport_photo) ? asset('admin/assets/img/avatar/avatar-5.png') : Storage::url($student->student->passport_photo) }}" class="mt-3 img-thumbnail" style="width: 250px; height:250px;" data-toggle="title" title="{{ $student->full_name }}">
                    </p>
                    <div class="d-inline-block">
                      <p class="text-muted">{{ Str::title($student->student->nationality ?? "N/A")  }}</p>
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
            <h1 class="mb-4 text-center">SSCE Results</h1>
            @if ($student && $student->student && $student->student->olevel_exams)
              @php
                $olevel_exams = json_decode($student->student->olevel_exams,
                true);
              @endphp

              @if (isset($olevel_exams['sittings']) && $olevel_exams['sittings'] > 0)
                <div class="row">
                  <div class="col-md-6">
                    @for ($i = 1; $i <= $olevel_exams['sittings']; $i++)
                      <div class="mb-4 card">
                        <div class="card-header">
                          <h5 class="mb-0">Sitting {{ $i }} <br> Year: {{ $olevel_exams['subjects']['sitting_' . $i][0]['year'] ?? 'N/A' }}</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group">
                            @foreach ($olevel_exams['subjects']['sitting_' . $i] as $subject)
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ Str::title($subject['subject']) }}
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
              <h3 class="mb-4 text-center">Student Documents</h3>
              @foreach ($documents as $label => $doc)
                <div class="mb-3 card card-body">
                  <strong>{{ Str::title(str_replace('_', ' ', $label)) }}:</strong>
                  @if ($doc['exists'])
                    @if ($doc['isPdf'])
                      <a href="{{ $doc['filePath'] }}" class="mt-2 btn btn-primary" target="_blank">Open PDF in New Tab</a>
                    @else
                      <button class="mt-2 btn btn-success" onclick="showImage('{{ $doc['filePath'] }}')">View Image</button>
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
