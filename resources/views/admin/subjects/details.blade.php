@extends('admin.layouts.adminLayout')

@section('title', 'Exam Details')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('admin.exam.manager') }}" class="btn btn-outline-primary">Create new <i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="float-left">
                                <select class="form-control selectric">
                                    <option>Action For Selected</option>
                                    <option>Move to Draft</option>
                                    <option>Move to Pending</option>
                                    <option>Delete Pemanently</option>
                                </select>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <tr>
                                        <th class="text-center pt-2" style="width: 12px">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    data-checkbox-role="dad" class="custom-control-input"
                                                    id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Title</th>
                                        <th>Venue</th>
                                        <th>Date/Time</th>
                                    </tr>
                                    @forelse ($exams as $exam)
                                    <tr>
                                        <td>
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input" id="checkbox-2">
                                                <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ Str::title($exam->department->name) }}
                                            <div class="table-links">
                                                <a href="{{ route('admin.exam.information', $exam->id) }}">View</a>
                                                <div class="bullet"></div>
                                                <a href="{{ route("admin.exam.edit", $exam->id) }}">Edit</a>
                                                <div class="bullet"></div>
                                                <a href="#" data-toggle="modal" data-target="#exampleModal" data-exam-id="{{ $exam->id }}" class="text-danger">Trash</a>
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            {{ Str::title($exam->venue) }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($exam->date_time)->format('jS F Y') }}</td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">Not available ...</div>
                                    @endforelse

                                </table>
                            </div>
                            <div class="mt-5">{{ $exams->links() }}</div>
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
             <a href="#" class="btn btn-danger" id="deleteExamBtn">Delete</a>
          </div>
       </div>
    </div>
  </div>
@endsection



@section('js')
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var examID = button.data('exam-id');
       var modal = $(this);
       modal.find('#deleteExamBtn').attr('href', '/admin/exam-management-details/del/' + examID);
    });
  </script>
@endsection