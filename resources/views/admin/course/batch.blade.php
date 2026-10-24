


<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Batches</h5>

            <span class="badge bg-primary">
                Total Batches: {{ $batches->count() }}
            </span>
        </div>

        @if ($batches->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Batch Name</th>
                            <th>No. of Live Classes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            <tr>
                                <td>{{ $batch->name }}</td>
                               <td>
                                <div class="px-3 py-2 rounded bg-light border text-center" style="min-width:120px;">
                                    <div class="fw-bold fs-4 text-primary">
                                        {{ $batch->leacture_count ?? 0 }}
                                    </div>
                                    <small class="text-muted">Live Classes</small>
                                </div>
                              </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No batches found.</p>
        @endif

    </div>
</div>
