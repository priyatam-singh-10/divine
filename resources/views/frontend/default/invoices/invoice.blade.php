<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .container {
            width: 100%;
        }

        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
            color: #006266
        }

        .company-info p {
            margin: 3px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background: #f5f5f5;
            text-align: left;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .text-right {
            text-align: right;
        }


        .nowrap {
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>

</head>

<body>

    @php
        $companyName = get_settings('system_name');
        $companyLogo = asset('uploads/dark_logo/darklogo-1748955956.png');
        $companyAddress = get_settings('address');
        $companyPhone = get_settings('phone');
        $companyEmail = get_settings('system_email');
        $companyGST = get_settings('company_gst');

        $user = get_user_info($invoice->user_id);
    @endphp


    <div class="container">

        <div class="invoice-header">

            <table width="100%">
                <tr>

                    <td>
                        {{-- <img src="{{ $companyLogo }}" alt="Logo" width="160"> --}}
                        <h3>{{ $companyName }}</h3>
                        <p>{{ $companyAddress }}</p>
                        <p><strong>Phone: </strong>{{ $companyPhone }}</p>
                        <p><strong>Email: </strong>{{ $companyEmail }}</p>

                        @if ($companyGST)
                            <p>GSTIN: {{ $companyGST }}</p>
                        @endif

                    </td>

                    <td class="text-right">
                        <p><strong>Invoice No:</strong> {{ $invoice->invoice }}</p>
                        <p><strong>Issue Date:</strong> {{ date('d M Y') }}</p>
                        <p><strong>Purchase Date:</strong> {{ date('d M Y', strtotime($invoice->created_at)) }}</p>

                    </td>

                </tr>
            </table>

        </div>


        <h3>Invoice To</h3>

        <p>
            <strong>{{ $user->name ?? 'N/A' }}</strong><br>
            {{ $user->email ?? '' }}<br>
            <!--{{ optional(json_decode($user->address))->city ?? '' }},-->
            <!--{{ optional(json_decode($user->address))->state ?? '' }},-->
            <!--{{ optional(json_decode($user->address))->country ?? '' }}<br>-->
            {{ $user->phone ?? '' }}
        </p>


        <table class="table">

            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>{{ $invoice->title }}</td>
                    <td class="text-center">1</td>
                    <td class="text-right">
                        <span class="nowrap">&#8377; {{ number_format($invoice->price, 2) }}</span>
                    </td>
                    <td class="text-right">
                        <span class="nowrap">&#8377; {{ number_format($invoice->price, 2) }}</span>
                    </td>
                </tr>

            </tbody>

        </table>


        <table width="100%" style="margin-top:20px;">
            <tr>

                <td></td>

                <td width="300">

                    <table width="100%">
                        <tr>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>&#8377; {{ number_format($invoice->price, 2) }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Payment Method</td>
                            <td class="text-right">{{ $invoice->payment_method }}</td>
                        </tr>
                    </table>

                </td>

            </tr>
        </table>


        <div class="footer">
            Thank you for your purchase!
            For any queries contact us at {{ $companyEmail }} or {{ $companyPhone }}
        </div>

    </div>

</body>

</html>
