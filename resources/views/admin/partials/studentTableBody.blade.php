@forelse ($students as $student)
    <tr>
        <td>
            <div class="custom-checkbox custom-control">
                <input type="checkbox" name="selected_students[]"
                    value="{{ $student->id }}" data-checkboxes="mygroup"
                    class="custom-control-input"
                    id="checkbox-{{ $student->id }}">
                <label for="checkbox-{{ $student->id }}"
                    class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>{{ $loop->iteration }}</td>
        <td class="align-middle">
            <a href="#" style="text-decoration:none;color:#444"
                data-toggle="modal" data-target="#mailModal"
                data-student-email="{{ $student->email }}">
                {{ Str::title($student->full_name ?? 'N/A') }}
                <br><code
                    style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;color:goldenrod">{{ $student->student->application_unique_number ?? 'N/A' }}</code>
            </a>
        </td>
        <td class="align-middle">
            {{ $student->student->phone }}
        </td>
        <td class="align-middle">
            @if ($student->applications->isNotEmpty())
                <p>{{ $student->applications->first()->department_name ?? 'N/A' }}</p>
            @else
                <p>N/A</p>
            @endif
        </td>
        <td class="align-middle">
            @if ($student->applications->contains('payment_id', '!=', null))
                <span style="background: teal !important"
                    class="badge badge-success text-light">Active Application</span>
            @else
                <span class="badge badge-primary text-light">Application Incomplete</span>
            @endif
        </td>
        <td class="align-middle">
            @if (!$student->applications->contains('payment_id', '!=', null))
                <a href="{{ route('admin.destroy.student', $student->nameSlug) }}"
                    onclick="return confirm('Are you sure of this action?')"
                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
            @endif
            <a href="{{ route('admin.show.student', $student->nameSlug) }}"
                class="btn btn-sm btn-info">
                <i class="fas fa-user"></i>
            </a>
            <a href="{{ route('admin.edit.student', $student->nameSlug) }}"
                class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i>
            </a>
            <a href="#" class="btn btn-sm btn-warning"
                data-toggle="modal" data-target="#mailModal"
                data-student-email="{{ $student->email }}">
                <i class="fas fa-envelope"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No students found.</td>
    </tr>
@endforelse
