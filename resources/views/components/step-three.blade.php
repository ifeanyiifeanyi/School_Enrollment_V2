{{-- @if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
    </div>
@endif --}}
{{-- Step 3 Footer --}}
@if (auth()->user()->canApplyForCurrentSession())
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
    </div>
@else
    <div class="card-footer">
        <div class="alert alert-info">
            {{ auth()->user()->getApplicationStatusMessage() }}
        </div>
    </div>
@endif
