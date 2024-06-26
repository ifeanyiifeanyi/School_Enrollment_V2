@forelse ($applications as $ap)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            {{ $ap->user->full_name ?? 'N/A' }}
            <p>
                <a href="{{ route('admin.show.student', $ap->user->nameSlug) }}"
                    class="mt-2 link">Details</a>
            </p>
        </td>
        <td>{{ $ap->user->student->application_unique_number ?? 'N/A' }}</td>
        <td>{{ Str::title($ap->department->name ?? 'N/A') }}</td>
        <td>{{ $ap->academicSession->session ?? 'N/A' }}</td>
        <td>{{ $ap->user->student->exam_score ?? 0 }}</td>
        <td>
            @if ($ap->admission_status == 'pending')
                <span class="badge bg-warning text-light">Pending <i class="fa fa-spinner fa-spin"></i></span>
            @elseif ($ap->admission_status == 'denied')
                <span class="badge bg-danger text-light">Denied <i class="fa fa-times"></i></span>
            @elseif ($ap->admission_status == 'approved')
                <span class="badge bg-success text-light">Approved <i class="fa fa-check"></i></span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No applications found.</td>
    </tr>
@endforelse
