<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
        }
        .success-card {
            max-width: 520px;
            margin: 80px auto;
            border-radius: 12px;
        }
        .check-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #e6f9f0;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow success-card text-center p-4">
        <div class="card-body">

            <div class="check-icon">✓</div>

            <h2 class="fw-bold text-success mb-2">
                Payment Successful
            </h2>

            <p class="text-muted mb-3">
                Your registration has been completed successfully.
            </p>

            @if(request('payment_id'))
                <p class="small text-muted mb-1">
                    <strong>Payment ID:</strong> {{ request('payment_id') }}
                </p>
            @endif

            @if(request('order_id'))
                <p class="small text-muted mb-3">
                    <strong>Order ID:</strong> {{ request('order_id') }}
                </p>
            @endif

            <hr>

            <p class="text-muted">
                You will receive confirmation details via Email shortly.
            </p>

            <div class="d-grid gap-2 mt-4">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    Go to Home
                </a>

                <a href="{{ url('/courses') }}" class="btn btn-outline-secondary">
                    View Courses
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
