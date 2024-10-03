@if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
    </div>
@endif
