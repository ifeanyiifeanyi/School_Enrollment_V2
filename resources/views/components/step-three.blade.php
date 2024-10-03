@if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
    </div>
@endif
