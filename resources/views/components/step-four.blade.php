@if (!auth()->user()->applications)
    <div class="card-footer">
        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
@endif
