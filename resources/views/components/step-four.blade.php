{{-- @if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
@endif
 --}}
{{-- Final Step Footer (Submit Button) --}}
@if (auth()->user()->canApplyForCurrentSession())
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
        <button type="submit" class="btn btn-success">Submit Application</button>
    </div>
@else
    <div class="card-footer">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ auth()->user()->getApplicationStatusMessage() }}
        </div>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
            Return to Dashboard
        </a>
    </div>
@endif
