{{-- @if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
    </div>
@endif --}}


{{-- Step 1 Footer --}}
@if (auth()->user()->canApplyForCurrentSession())
    <div class="card-footer">
        <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
    </div>
@else
    <div class="card-footer">
        <div class="alert alert-info">
            {{ auth()->user()->getApplicationStatusMessage() }}
        </div>
    </div>
@endif

