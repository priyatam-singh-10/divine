<div class="ol-card p-3 mb-3">
<ul class="nav nav-tabs">

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.payment.history') ? 'active' : '' }}"
href="{{ route('admin.payment.history') }}">
Payment History
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.purchase.history') ? 'active' : '' }}"
href="{{ route('admin.purchase.history') }}">
Course Purchases
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}"
href="{{ route('admin.orders') }}">
Book Orders
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.revenue') ? 'active' : '' }}"
href="{{ route('admin.revenue') }}">
Admin Revenue
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.webinar.purchase.history') ? 'active' : '' }}"
href="{{ route('admin.webinar.purchase.history') }}">
Webinar Purchases
</a>
</li>

</ul>
</div>