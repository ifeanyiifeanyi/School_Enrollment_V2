@forelse ($applications as $ap)
<tr>
    {{-- <td><input type="checkbox" class="application-checkbox"
            value="{{ $ap->id }}"></td> --}}
    <td>{{ $loop->iteration }}</td>
    <td>
        {{ Str::title($ap->user->full_name) ?? 'N/A' }}
        <p>
            <a href="{{ route('admin.show.student', $ap->user->nameSlug) }}"
                class="mt-2 link">Details</a>
        </p>
    </td>
    <td>
        <p>{{ $ap->user->student->phone }}</p>
    </td>
    <td>{{ $ap->user->student->application_unique_number ?? 'N/A' }}</td>
    <td>{{ Str::title($ap->department->name ?? 'N/A') }}</td>
    {{-- <td>{{ $ap->academicSession->session ?? 'N/A' }}</td> --}}

    {{-- <td>{{ $ap->user->student->exam_score ?? 0 }}</td> --}}
    <td>
        @if ($ap->admission_status == 'pending')
            <span class="badge bg-warning text-light">Pending <i
                    class="fa fa-spinner fa-spin"></i></span>
        @elseif ($ap->admission_status == 'denied')
            <span class="badge bg-danger text-light">Denied <i
                    class="fa fa-times"></i></span>
        @elseif ($ap->admission_status == 'approved')
            <span class="badge bg-success text-light">Approved <i
                    class="fa fa-check"></i></span>
        @endif
    </td>

    <td>
        @if ($ap->admission_status == 'pending')
            <p>
            <form action="{{ route('admin.approve.admission', $ap->id) }}" method="POST">
                @csrf

                <button title="Approve Pending Student Admission" type="submit" class="btn btn-sm btn-success"
                    onclick="return confirm('Are you sure you want to approve this application?')">Approve</button>
            </form>
            </p>
        @elseif ($ap->admission_status == 'approved')
            <p>
            <form action="{{ route('admin.deny.application', $ap->id) }}"
                method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <button title="Set Student admission status back to pending" type="submit" class="btn btn-sm btn-warning"
                    onclick="return confirm('Are you sure you want to set this application to pending?')">Set
                    Pending</button>
            </form>
            </p>
        @endif
    </td>
</tr>
@empty
<div class="text-center alert alert-danger">Not available</div>
@endforelse
