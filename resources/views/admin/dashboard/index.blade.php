@extends('layouts.admin')
@push('title', get_phrase('Dashboard'))
@push('meta')@endpush
@push('css')
@endpush

@php
use Illuminate\Support\Facades\DB;
$totalWebinars = DB::table('bootcamps')->count();
$totalWebinarPurchases = DB::table('bootcamp_purchases')->count();

$linkPurchases = DB::connection('mysql2')->table('purchases')->count();

$linkRevenue = DB::connection('mysql2')->table('purchases')->sum('price');

/* ---------- TODAY ---------- */
$todayWebinarPurchases = DB::table('bootcamp_purchases')
    ->whereDate('created_at', today())
    ->count();

$todayLinkPurchases = DB::connection('mysql2')
    ->table('purchases')
    ->whereDate('purchase_date', today())
    ->count();

$todayLinkRevenue = DB::connection('mysql2')
    ->table('purchases')
    ->whereDate('purchase_date', today())
    ->sum('price');


/* ---------- MONTHLY ---------- */
$monthlyWebinarPurchases = DB::table('bootcamp_purchases')
    ->whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->count();

$monthlyLinkPurchases = DB::connection('mysql2')
    ->table('purchases')
    ->whereMonth('purchase_date', now()->month)
    ->whereYear('purchase_date', now()->year)
    ->count();

$monthlyLinkRevenue = DB::connection('mysql2')
    ->table('purchases')
    ->whereMonth('purchase_date', now()->month)
    ->whereYear('purchase_date', now()->year)
    ->sum('price');
@endphp
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Dashboard') }}
                </h4>
            </div>
        </div>
    </div>
    
    <div class="today-overview">
        <h4 class="title fs-14px">Today’s Overview</h4>
        <div class="row g-2 g-sm-3 my-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
            <!-- Today's Book Orders -->
            <div class="col">
                <a href="{{ route('admin.orders') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2"> {{ App\Models\Order::whereDate('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Today Book Orders') }}</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('admin.reservations') }}?date=today" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">
                            {{ App\Models\CourseReservation::whereDate('created_at', today())->count() }}
                        </p>
                        <p class="sub-title fs-14px">
                            {{ get_phrase('Today Reservations') }}
                        </p>
                    </div>
                </a>
            </div>

            
            <!-- Today's Consultation Services -->
            <div class="col">
                <a href="{{ route('admin.consultation-services') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\ConsultingService::whereDate('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Today Consultation') }}</p>
                    </div>
                </a>
            </div>
            
            <!-- Today's Purchase Course -->
            <div class="col">
                <a href="{{ route('admin.purchase.history') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Payment_history::whereDate('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Today Purchase Course') }}</p>
                    </div>
                </a>
            </div>
            
            <!-- Today's Enquiry -->
            <div class="col">
                <a href="{{ route('admin.enquiries') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Enquiry::whereDate('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Today Enquiries') }}</p>
                    </div>
                </a>
            </div>
            <div class="col">
<a href="#" class="ol-card card-hover w-100">
<div class="ol-card-body px-20px py-3">
<p class="title fs-18px my-2">{{ $todayWebinarPurchases }}</p>
<p class="sub-title fs-14px">Today Webinar Purchases</p>
</div>
</a>
</div>

<!-- Today Purchase Link Sales -->
<div class="col">
<a href="#" class="ol-card card-hover w-100">
<div class="ol-card-body px-20px py-3">
<p class="title fs-18px my-2">{{ $todayLinkPurchases }}</p>
<p class="sub-title fs-14px">Today Purchase-Link Sales</p>
</div>
</a>
</div>

<!-- Today Link Revenue -->
<div class="col">
<a href="#" class="ol-card card-hover w-100">
<div class="ol-card-body px-20px py-3">
<p class="title fs-18px my-2">₹{{ number_format($todayLinkRevenue) }}</p>
<p class="sub-title fs-14px">Today Purchase-Link Revenue</p>
</div>
</a>
</div>
        </div>
        
        <!-- Today Webinar Purchases -->

    </div>
    
    <div class="month-overview">
        <h4 class="title fs-14px">Monthly Overview</h4>
        
        <div class="row g-2 g-sm-3 my-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
            <!-- Monthly Book Orders -->
            <div class="col">
                <a href="{{ route('admin.orders') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2"> {{ App\Models\Order::whereMonth('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Monthly Book Orders') }}</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('admin.reservations') }}?month=current" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">
                            {{ App\Models\CourseReservation::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count() }}
                        </p>
                        <p class="sub-title fs-14px">
                            {{ get_phrase('Monthly Reservations') }}
                        </p>
                    </div>
                </a>
            </div>

            
            <!-- Monthlys Consultation Services -->
            <div class="col">
                <a href="{{ route('admin.consultation-services') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\ConsultingService::whereMonth('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Monthly Consultation') }}</p>
                    </div>
                </a>
            </div>
            
            <!-- Monthly Purchase Course -->
            <div class="col">
                <a href="{{ route('admin.purchase.history') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Payment_history::whereMonth('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Monthly Purchase Course') }}</p>
                    </div>
                </a>
            </div>
            
            <!-- Enquiries This Month -->
            <div class="col">
                <a href="{{ route('admin.enquiries') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2"> {{ App\Models\Enquiry::whereMonth('created_at', now()->month)->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Monthly Enquiries') }}</p>
                    </div>
                </a>
            </div>
            <!-- Monthly Webinar Purchases -->
        <div class="col">
        <a href="#" class="ol-card card-hover w-100">
        <div class="ol-card-body px-20px py-3">
        <p class="title fs-18px my-2">{{ $monthlyWebinarPurchases }}</p>
        <p class="sub-title fs-14px">Monthly Webinar Purchases</p>
        </div>
        </a>
        </div>
        
        <!-- Monthly Link Sales -->
        <div class="col">
        <a href="#" class="ol-card card-hover w-100">
        <div class="ol-card-body px-20px py-3">
        <p class="title fs-18px my-2">{{ $monthlyLinkPurchases }}</p>
        <p class="sub-title fs-14px">Monthly Purchase-Link Sales</p>
        </div>
        </a>
        </div>
        
        <!-- Monthly Link Revenue -->
        <div class="col">
        <a href="#" class="ol-card card-hover w-100">
        <div class="ol-card-body px-20px py-3">
        <p class="title fs-18px my-2">₹{{ number_format($monthlyLinkRevenue) }}</p>
        <p class="sub-title fs-14px">Monthly Purchase-Link Revenue</p>
        </div>
        </a>
        </div>
        </div>
     </div>
            
    <div class="overview">
        <h4 class="title fs-14px">Overall Overview</h4>
        <div class="row g-2 g-sm-3 my-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
            <!-- Number of Book Orders -->
             <div class="col">
                <a href="{{ route('admin.orders') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Order::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Book Orders') }}</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('admin.reservations') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">
                            {{ App\Models\CourseReservation::count() }}
                        </p>
                        <p class="sub-title fs-14px">
                            {{ get_phrase('Total Reservations') }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- Consultation Services -->
            <div class="col">
                <a href="{{ route('admin.consultation-services') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\ConsultingService::whereDate('created_at', today())->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Consultation') }}</p>
                    </div>
                </a>
            </div>
            
            <div class="col">
                <a href="{{ route('admin.courses') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Course::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Courses') }}</p>
                    </div>
                </a>
            </div>
            
            <!-- Total Webinars -->
            <div class="col">
            <a href="#" class="ol-card card-hover w-100">
            <div class="ol-card-body px-20px py-3">
            <p class="title card-title-hover fs-18px my-2">{{ $totalWebinars }}</p>
            <p class="sub-title fs-14px">Total Webinars</p>
            </div>
            </a>
            </div>
            
            <!-- Webinar Purchases -->
            <div class="col">
            <a href="#" class="ol-card card-hover w-100">
            <div class="ol-card-body px-20px py-3">
            <p class="title card-title-hover fs-18px my-2">{{ $totalWebinarPurchases }}</p>
            <p class="sub-title fs-14px">Webinar Purchases</p>
            </div>
            </a>
            </div>
            
            <!-- Purchase Link Purchases -->
            <div class="col">
            <a href="#" class="ol-card card-hover w-100">
            <div class="ol-card-body px-20px py-3">
            <p class="title card-title-hover fs-18px my-2">{{ $linkPurchases }}</p>
            <p class="sub-title fs-14px">Total Purchase-Link Sales</p>
            </div>
            </a>
            </div>
            
            <!-- Purchase Link Revenue -->
            <div class="col">
            <a href="#" class="ol-card card-hover w-100">
            <div class="ol-card-body px-20px py-3">
            <p class="title card-title-hover fs-18px my-2">₹{{ number_format($linkRevenue) }}</p>
            <p class="sub-title fs-14px">Total Purchase-Link Revenue</p>
            </div>
            </a>
            </div>
        
            <div class="col">
                <a href="{{ route('admin.purchase.history') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Payment_history::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Payment') }}</p>
                    </div>
                </a>
            </div>
        
            <div class="col">
                <a href="{{ route('admin.enquiries') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Enquiry::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Enquiry') }}</p>
                    </div>
                </a>
            </div>
        
            <div class="col">
                <a href="{{ route('admin.student.index') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\User::where('role', 'student')->count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Students') }}</p>
                    </div>
                </a>
            </div>
        
            <div class="col">
                <a href="{{ route('admin.contacts') }}" class="ol-card card-hover w-100">
                    <div class="ol-card-body px-20px py-3">
                        <p class="title card-title-hover fs-18px my-2">{{ App\Models\Contact::count() }}</p>
                        <p class="sub-title fs-14px">{{ get_phrase('Total Contact') }}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

        
    <div class="row">
        <div class="col-xl-12">
            <div class="ol-card p-3">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title fs-14px">{{ get_phrase('Admin Revenue This Year') }}</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn-link" href="{{route('admin.revenue')}}" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="{{ get_phrase('Admin Revenue') }}"><i class="fi-rr-arrow-alt-right"></i></a>
                    </div>
                </div>
                <div class="ol-card-body">
                    <canvas id="myChart" class="mw-100 w-100" height="320px"></canvas>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>


    <div class="row my-3">
        <div class="col-md-5">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title fs-14px">{{get_phrase('Course Status')}}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn-link" href="{{route('admin.courses')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="{{ get_phrase('Explore Courses') }}"><i class="fi-rr-arrow-alt-right"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center g-30px flex-wrap flex-xl-nowrap justify-content-center">
                        <div class="pie-chart-sm">
                            <canvas id="pie2"></canvas>
                        </div>
                        <div class="pie-chart-sm-details">
                            <ul class="color-info-list">
                                <li>
                                    <span class="info-list-color bg-active"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Active')}}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-upcoming"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Upcoming')}}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-pending"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Pending')}}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-private"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Private')}}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-draft"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Draft')}}</span>
                                </li>
                                <li>
                                    <span class="info-list-color bg-inactive"></span>
                                    <span class="title2 fs-14px">{{get_phrase('Inactive')}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="ol-card" id = 'unpaid-instructor-revenue'>
                <div class="ol-card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title text-14px mb-3">{{ get_phrase('Pending Requested withdrawal') }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn-link" href="{{route('admin.instructor.payout')}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="{{ get_phrase('Instructor Payout') }}"><i class="fi-rr-arrow-alt-right"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-hover mb-0">
                            <tbody>
                                @php
                                    $payouts = App\Models\Payout::where('status', '!=', 1)->limit(20)->orderBy('id')->get();
                                @endphp
                                @foreach($payouts as $payout)
                                <tr>
                                    <td>
                                        <p class="title fs-14px">{{ get_phrase('Name') }}: {{$payout->user->name}}</p>
                                        <small>{{ get_phrase('Email') }}: <span class="text-muted font-13">{{$payout->user->email}}</span></small>
                                    </td>
                                    <td>
                                        <p class="title fs-14px">{{currency($payout->amount)}}</p>
                                        <small><span class="text-muted font-13">{{ get_phrase('Requested withdrawal amount') }}</span></small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $courses = App\Models\Course::get()->groupBy('status');
        $active = isset($courses['active']) ? $courses['active']->count():0;
        $upcoming = isset($courses['upcoming']) ? $courses['upcoming']->count():0;
        $pending = isset($courses['pending']) ? $courses['pending']->count():0;
        $private = isset($courses['private']) ? $courses['private']->count():0;
        $draft = isset($courses['draft']) ? $courses['draft']->count():0;
        $inactive = isset($courses['inactive']) ? $courses['inactive']->count():0;
    @endphp
    
@endsection

@push('js')

    {{-- Oliv template start --}}
    <script src="{{ asset('assets/backend/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/chart-js/chart.js') }}"></script>
    {{-- Oliv template end --}}


    <script>
        "use strict";

        const xValues = [0, "January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "{{get_phrase('Admin revenue')}}",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: <?php print_r(json_encode($monthly_amount)); ?>
                }]
            },
            options: {
                legend: {
                    display: true
                },
            }
        });


        // Pie Chart 2
        const project_progress2 = document.getElementById('pie2');
        const progressData2 = {
            labels: ['Active', 'Upcoming', 'Pending', 'Private', 'Draft', 'Inactive'],
            data: [{{$active}}, {{$upcoming}}, {{$pending}}, {{$private}}, {{$draft}}, {{$inactive}}],
        };
        var barColors = [
            "#12c093",
            "#1b84ff",
            "#ff2583",
            "#000",
            "#878d97",
            "#dadada",
        ];
        new Chart(project_progress2, {
            type: 'doughnut',
            data: {
                labels: progressData2.labels,
                datasets: [{
                    backgroundColor: barColors,
                    label: ' {{get_phrase("Courses")}}',
                    data: progressData2.data,
                }, ],
            },
            options: {
                responsive: true,
                borderWidth: 5,
                hoverBorderColor: '#fff',
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    </script>
@endpush
