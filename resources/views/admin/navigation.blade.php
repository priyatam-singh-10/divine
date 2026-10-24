@php $current_route = Route::currentRouteName(); @endphp

<div class="sidebar-logo-area">
    <a href="{{ route('home') }}" class="sidebar-logos">
        <img class="sidebar-logo-lg" height="50px" src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="">
        <img class="sidebar-logo-sm" height="40px" src="{{ get_image(get_frontend_settings('favicon')) }}" alt="">
    </a>
    <button class="sidebar-cross menu-toggler d-block d-lg-none">
        <span class="fi-rr-cross"></span>
    </button>
</div>

<div class="sidebar-nav-area pt-4">
    <nav class="sidebar-nav">
        <ul class="px-14px pb-24px">

            @if (has_permission('admin.dashboard'))
                <li class="sidebar-first-li {{ $current_route == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="icon fi-rr-house-blank"></span>
                        <div class="text">
                            <span>{{ get_phrase('Dashboard') }}</span>
                        </div>
                    </a>
                </li>
            @endif


            <!--@if (has_permission('admin.categories'))-->
            <!--    <li class="sidebar-first-li {{ $current_route == 'admin.categories' ? 'active' : '' }}">-->
            <!--        <a href="{{ route('admin.categories') }}">-->
            <!--            <span class="icon fi-rr-chart-tree-map"></span>-->
            <!--            <div class="text">-->
            <!--                <span>{{ get_phrase('Service Category') }}</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--@endif-->
            
            

           @if (has_permission('admin.admins.index') || has_permission('admin.instructor.index') || has_permission('admin.student.index') || has_permission('admin.enroll.history') 
           || has_permission('admin.student.enroll') || has_permission('admin.purchase.history')|| has_permission('admin.link-enroll.purchasehistory'))
            <li class="sidebar-first-li first-li-have-sub @if (
                $current_route == 'admin.instructor.index' ||
                $current_route == 'link-enroll.purchasehistory'||
                $current_route == 'admin.instructor.create' ||
                $current_route == 'admin.instructor.edit' ||
                $current_route == 'admin.instructor.payout' ||
                $current_route == 'admin.instructor.payout.filter' ||
                $current_route == 'admin.instructor.setting' ||
                $current_route == 'admin.instructor.application' ||
                $current_route == 'admin.enroll.history' ||
                $current_route == 'admin.admins.index' ||
                $current_route == 'admin.admins.create' ||
                $current_route == 'admin.admins.edit' ||
                $current_route == 'admin.admins.permission' ||
                $current_route == 'admin.student.index' ||
                $current_route == 'admin.student.edit' ||
                $current_route == 'admin.student.create' ||
                $current_route == 'admin.student.deleteduserindex'
            ) active @endif">

        <a href="javascript:void(0);">
            <span class="icon fi-rr-users"></span>
            <div class="text">
                <span>{{ get_phrase('Members') }}</span>
            </div>
        </a>
        
        <ul class="first-sub-menu">
        
        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Users') }}</li>
        
        {{-- Instructor (Hidden Parent) --}}
        @if (has_permission('admin.instructor.index'))
        <li class="d-none sidebar-second-li second-li-have-sub @if (
            $current_route == 'admin.instructor.index' ||
            $current_route == 'admin.instructor.create' ||
            $current_route == 'admin.instructor.edit' ||
            $current_route == 'admin.instructor.payout' ||
            $current_route == 'admin.instructor.payout.filter' ||
            $current_route == 'admin.instructor.setting' ||
            $current_route == 'admin.instructor.application'
        ) active @endif">
        
        <a href="javascript:void(0);">{{ get_phrase('Instructor') }}</a>
        
        <ul class="second-sub-menu">
        
        <li class="sidebar-third-li @if ($current_route == 'admin.instructor.index' || $current_route == 'admin.instructor.edit') active @endif">
        <a href="{{ route('admin.instructor.index') }}">{{ get_phrase('Manage Instructors') }}</a>
        </li>
        
        <li class="d-none sidebar-third-li @if ($current_route == 'admin.instructor.create') active @endif">
        <a href="{{ route('admin.instructor.create') }}">{{ get_phrase('Add new Instructor') }}</a>
        </li>
        
        <li class="sidebar-third-li @if ($current_route == 'admin.instructor.payout' || $current_route == 'admin.instructor.payout.filter') active @endif">
        <a href="{{ route('admin.instructor.payout') }}">{{ get_phrase('Instructor Payout') }}</a>
        </li>
        
        <li class="sidebar-third-li @if ($current_route == 'admin.instructor.setting') active @endif">
        <a href="{{ route('admin.instructor.setting') }}">{{ get_phrase('Instructor Setting') }}</a>
        </li>
        
        <li class="d-none sidebar-third-li @if ($current_route == 'admin.instructor.application') active @endif">
        <a href="{{ route('admin.instructor.application') }}">{{ get_phrase('Application') }}</a>
        </li>
        
        </ul>
        </li>
        @endif
        
        
        {{-- Manage User --}}
        @if (has_permission('admin.student.index'))
        <li class="sidebar-second-li @if ($current_route == 'admin.student.index' || $current_route == 'admin.student.edit') active @endif">
            <a href="{{ route('admin.student.index') }}">
                {{ get_phrase('Manage User') }}
            </a>
        </li>
        @endif
        
        
        {{-- Deleted User --}}
        @if (has_permission('admin.student.deleteduserindex'))
        <li class="sidebar-second-li @if ($current_route == 'admin.student.deleteduserindex') active @endif">
            <a href="{{ route('admin.student.deleteduserindex') }}">
                {{ get_phrase('Deleted User') }}
            </a>
        </li>
        @endif
        
        {{-- Enrollment History --}}
        @if (has_permission('admin.enroll.history'))
        <li class="sidebar-second-li {{ $current_route == 'admin.enroll.history' ? 'active' : '' }}">
            <a href="{{ route('admin.enroll.history') }}">
                {{ get_phrase('Enrollment History') }}
            </a>
        </li>
        @endif
        
        {{-- Enroll Link Purchase History --}}
        <li class="sidebar-second-li {{ $current_route == 'admin.link-enroll.purchasehistory' ? 'active' : '' }}">
            <a href="{{ route('admin.link-enroll.purchasehistory') }}">
                {{ get_phrase('Enroll Link Purchase History') }}
            </a>
        </li>
        
        {{-- Add User (Hidden) --}}
        <li class="d-none sidebar-second-li @if ($current_route == 'admin.student.create') active @endif">
            <a href="{{ route('admin.student.create') }}">
                {{ get_phrase('Add new User') }}
            </a>
        </li>
        
        </ul>
        </li>
        @endif
            @if (has_permission('admin.webinars'))
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.webinars' || $current_route == 'admin.webinar.create' || $current_route == 'admin.webinar.edit' || $current_route == 'admin.webinar.purchase.invoice' || $current_route == 'admin.webinar.categories' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-sr-users-alt"></span>
                        <div class="text">
                            <span>{{ get_phrase('Webinars') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <!--<li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Bootcamp') }}</li>-->
                        <li class="first-sub-menu-title fs-14px mb-18px">Webinars</li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.webinar.categories' ? 'active' : '' }}">
                            <a href="{{ route('admin.webinar.categories') }}">{{ get_phrase('Webinar Category') }}</a>
                        </li>
                        <li class="sidebar-second-li @if (($current_route == 'admin.webinars' || $current_route == 'admin.webinar.edit') && request('type') == '') active @endif"><a href="{{ route('admin.webinars') }}">{{ get_phrase('Manage Webinars') }}</a></li>
                        <li class="d-none sidebar-second-li @if ($current_route == 'admin.webinar.create') active @endif">
                            <a href="{{ route('admin.webinar.create') }}">{{ get_phrase('Add New Webinar') }}</a>
                        </li>
                        <!--<li class="sidebar-second-li {{ $current_route == 'admin.webinar.purchase.history' || $current_route == 'admin.webinar.purchase.invoice' ? 'active' : '' }}">-->
                        <!--    <a href="{{ route('admin.webinar.purchase.history') }}">{{ get_phrase('Webinar Purchase History') }}</a>-->
                        <!--</li>-->
                        
                    </ul>
                </li>
            @endif
            
            
            <li class="d-none sidebar-second-li {{ $current_route == 'link-enroll.purchasehistory' ? 'active' : '' }}">
                <a href="{{ route('admin.link-enroll.purchasehistory') }}">
                    {{ get_phrase('Link Enroll Purchase History') }}
                </a>
            </li>
            
            
            
            

            <!--@if (has_permission('admin.courses'))-->
            <!--    <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.courses' || $current_route == 'admin.course.create' || $current_route == 'admin.course.edit' || $current_route == 'admin.coupons') active showMenu @endif">-->
            <!--        <a href="javascript:void(0);">-->
            <!--            <span class="icon fi fi-rr-e-learning"></span>-->
            <!--            <div class="text">-->
            <!--                <span>{{ get_phrase('Course') }}</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <ul class="first-sub-menu">-->
            <!--            <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Course') }}</li>-->
            <!--            <li class="sidebar-second-li @if ($current_route == 'admin.courses' || $current_route == 'admin.course.edit') active @endif">-->
            <!--                <a href="{{ route('admin.courses') }}">{{ get_phrase('Manage Courses') }}</a>-->
            <!--            </li>-->
            <!--            <li class="d-none sidebar-second-li @if ($current_route == 'admin.course.create') active @endif">-->
            <!--                <a href="{{ route('admin.course.create') }}">{{ get_phrase('Add New Course') }}</a>-->
            <!--            </li>-->
            <!--            <li class="sidebar-second-li @if ($current_route == 'admin.coupons') active @endif">-->
            <!--                <a href="{{ route('admin.coupons') }}">{{ get_phrase('Offers') }}</a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--@endif-->
            @if (has_permission('admin.courses'))
            <li class="sidebar-first-li first-li-have-sub 
            @if (
            $current_route == 'admin.courses' ||
            $current_route == 'admin.course.create' ||
            $current_route == 'admin.course.edit' ||
            $current_route == 'admin.coupons' ||
            $current_route == 'admin.batch.index' ||
            $current_route == 'admin.batch.create' ||
            $current_route == 'admin.batch.edit' ||
            $current_route == 'admin.batch.show'
            ) active showMenu @endif">
            
                <a href="javascript:void(0);">
                    <span class="icon fi fi-rr-e-learning"></span>
                    <div class="text">
                        <span>{{ get_phrase('Course') }}</span>
                    </div>
                </a>
            
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Course') }}</li>
            
                    <li class="sidebar-second-li @if ($current_route == 'admin.courses' || $current_route == 'admin.course.edit') active @endif">
                        <a href="{{ route('admin.courses') }}">{{ get_phrase('Manage Courses') }}</a>
                    </li>
            
                    <li class="d-none sidebar-second-li @if ($current_route == 'admin.course.create') active @endif">
                        <a href="{{ route('admin.course.create') }}">{{ get_phrase('Add New Course') }}</a>
                    </li>
            
                    <li class="sidebar-second-li @if (
                        $current_route == 'admin.batch.index' ||
                        $current_route == 'admin.batch.create' ||
                        $current_route == 'admin.batch.edit' ||
                        $current_route == 'admin.batch.show'
                    ) active @endif">
                        <a href="{{ route('admin.batch.index') }}">{{ get_phrase('Manage Batches') }}</a>
                    </li>
            
                    <li class="sidebar-second-li @if ($current_route == 'admin.coupons') active @endif">
                        <a href="{{ route('admin.coupons') }}">{{ get_phrase('Offers') }}</a>
                    </li>
                </ul>
            </li>
            @endif
            
              @if (has_permission('admin.reservations'))
                <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.reservations') active showMenu @endif">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-ticket"></span>
                        <div class="text">
                            <span>{{ get_phrase('Reservations') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Reservations') }}</li>
                        <li class="sidebar-second-li @if ($current_route == 'admin.reservations') active @endif">
                            <a href="{{ route('admin.reservations') }}">{{ get_phrase('Reservations') }}</a>
                        </li>
                       
                    </ul>
                </li>
            @endif
            
            @if (has_permission('admin.offline.payments') || has_permission('admin.revenue') || has_permission('admin.instructor.revenue') || has_permission('admin.payment.history'))
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.offline.payments' || $current_route == 'admin.revenue' || $current_route == 'admin.instructor.revenue' || $current_route == 'admin.payment.history' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi-rr-wallet"></span>
                        <div class="text">
                            <span>{{ get_phrase('Payments') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Payment Report') }}</li>

                        <!--@if (has_permission('admin.offline.payments'))-->
                        <!--    <li class="sidebar-second-li {{ $current_route == 'admin.offline.payments' ? 'active' : '' }}">-->
                        <!--        <a href="{{ route('admin.offline.payments') }}">{{ get_phrase('Offline payments') }}</a>-->
                        <!--    </li>-->
                        <!--@endif-->

                        @if (has_permission('admin.revenue'))
                            <li class="d-none sidebar-second-li {{ $current_route == 'admin.revenue' ? 'active' : '' }}"><a href="{{ route('admin.revenue') }}">{{ get_phrase('Admin Revenue') }}</a></li>
                        @endif
                        @if (has_permission('admin.instructor.revenue'))
                            <li class="d-none sidebar-second-li {{ $current_route == 'admin.instructor.revenue' ? 'active' : '' }}">
                                <a href="{{ route('admin.instructor.revenue') }}">{{ get_phrase('Instructor Revenue') }}</a>
                            </li>
                        @endif
                      
                        
                        @if (has_permission('admin.payment.history'))
                            <li class="sidebar-second-li {{ $current_route == 'admin.payment.history' || $current_route == 'admin.purchase.history.invoice' ? 'active' : '' }}">
                                <a href="{{ route('admin.payment.history') }}">{{ get_phrase('Payment History') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            
            
            @if (has_permission('admin.enroll.history') || has_permission('admin.student.enroll')||has_permission('admin.purchase.history'))
                <li class="d-none sidebar-first-li first-li-have-sub {{ $current_route == 'admin.student.enroll' || $current_route == 'admin.enroll.history'  || $current_route == 'admin.purchase.history.invoice' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi-rr-elevator"></span>
                        <div class="text">
                            <span>{{ get_phrase('Course enrollment') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Course enrollment') }}</li>

                        @if (has_permission('admin.enroll.history'))
                            <li class="sidebar-second-li {{ $current_route == 'admin.enroll.history' ? 'active' : '' }}">
                                <a href="{{ route('admin.enroll.history') }}">{{ get_phrase('Enrollment History') }}</a>
                            </li>
                        @endif
                        <!-- @if (has_permission('admin.purchase.history'))-->
                        <!--    <li class="sidebar-second-li {{ $current_route == 'admin.purchase.history' || $current_route == 'admin.purchase.history.invoice' ? 'active' : '' }}">-->
                        <!--        <a href="{{ route('admin.purchase.history') }}">{{ get_phrase('Course Purchase') }}</a>-->
                        <!--    </li>-->
                        <!--@endif-->
                        @if (has_permission('admin.student.enroll'))
                            <li class="d-none sidebar-second-li {{ $current_route == 'admin.student.enroll' ? 'active' : '' }}">
                                <a href="{{ route('admin.student.enroll') }}">{{ get_phrase('Enroll course') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            
            @if (has_permission('admin.books') || has_permission('admin.orders'))
            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.books') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-br-book-alt pt-1"></span>
                    <div class="text">
                        <span>{{ get_phrase('eBook') }}</span>
                    </div>
                </a>    
                <ul class="first-sub-menu">
            
                    @if (has_permission('admin.books'))
                    <li class="sidebar-second-li @if ($current_route == 'admin.books') active @endif">
                        <a href="{{ route('admin.books') }}">{{ get_phrase('Books') }}</a>
                    </li>
                    @endif
            
                    <!--@if (has_permission('admin.orders'))-->
                    <!--<li class="sidebar-second-li @if ($current_route == 'admin.orders') active @endif">-->
                    <!--    <a href="{{ route('admin.orders') }}">{{ get_phrase('Book Orders') }}</a>-->
                    <!--</li>-->
                    <!--@endif-->
                </ul>
            </li>
            @endif

            @if (has_permission('admin.blogs'))
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.blogs' || $current_route == 'admin.blog.create' || $current_route == 'admin.blog.edit' || $current_route == 'admin.blog.pending' || $current_route == 'admin.blog.category' || $current_route == 'admin.blog.settings' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-blog-text"></span>
                        <div class="text">
                            <span>{{ get_phrase('Blogs') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Blogs') }}</li>

                        <li class="sidebar-second-li {{ $current_route == 'admin.blogs' ? 'active' : '' }}"><a href="{{ route('admin.blogs') }}">{{ get_phrase('Manage Blogs') }}</a>
                        </li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.blog.pending' ? 'active' : '' }}"><a href="{{ route('admin.blog.pending') }}">{{ get_phrase('Pending Blogs') }}</a></li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.blog.category' ? 'active' : '' }}"><a href="{{ route('admin.blog.category') }}">{{ get_phrase('Category') }}</a></li>
                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.blog.settings' ? 'active' : '' }}"><a href="{{ route('admin.blog.settings') }}">{{ get_phrase('Settings') }}</a></li>
                    </ul>
                </li>
            @endif
            
            
            
            @if (has_permission('admin.consultation-services'))
            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.consultation-services' || $current_route == 'admin.consultation-services-slots') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-br-user"></span>
                    <div class="text">
                        <span>{{ get_phrase('Consultations') }}</span> 
                    </div>
                </a>
                <ul class="first-sub-menu">
                    {{-- Manage Consultation Services --}}
                    <li class="sidebar-second-li @if ($current_route == 'admin.consultation-services') active @endif">
                        <a href="{{ route('admin.consultation-services') }}">{{ get_phrase('Services') }}</a>
                    </li>
            
                    {{-- Manage Slots --}}
                    <li class="sidebar-second-li @if ($current_route == 'admin.consultation-services-slots') active @endif">
                        <a href="{{ route('admin.consultation-services-slots') }}">{{ get_phrase('Slots') }}</a>
                    </li>
                </ul>
            </li>
            @endif

            @if (has_permission('admin.contacts') || has_permission('admin.enquiries'))
            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.contacts' || $current_route == 'admin.enquiries') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-br-portrait pt-1"></span>
                    <div class="text">
                        <span>{{ get_phrase('Communication') }}</span> {{-- Parent menu name --}}
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Communication') }}</li>
            
                    @if (has_permission('admin.contacts'))
                    <li class="sidebar-second-li @if ($current_route == 'admin.contacts') active @endif">
                        <a href="{{ route('admin.contacts') }}">{{ get_phrase('Contacts') }}</a>
                    </li>
                    @endif
            
                    <!--@if (has_permission('admin.enquiries'))-->
                    <!--<li class="sidebar-second-li @if ($current_route == 'admin.enquiries') active @endif">-->
                    <!--    <a href="{{ route('admin.enquiries') }}">{{ get_phrase('Enquiries') }}</a>-->
                    <!--</li>-->
                    <!--@endif-->
                </ul>
            </li>
            @endif
            
            @if (has_permission('admin.leads.list') || has_permission('admin.ai-wealth-crm.inquiries'))
                <li
                    class="sidebar-first-li first-li-have-sub 
                {{ $current_route == 'admin.ai-wealth-crm.inquiries' ? 'active showMenu' : '' }}">

                    <a href="javascript:void(0);">
                        <span class="icon fi fi-sr-briefcase"></span>
                        <div class="text">
                            <span>{{ get_phrase('AI Wealth CRM') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">
                            {{ get_phrase('AI Wealth CRM') }}
                        </li>

                        <li
                            class="sidebar-second-li 
                    {{ $current_route == 'admin.ai-wealth-crm.inquiries' ? 'active' : '' }}">
                            <a href="{{ route('admin.ai-wealth-crm.inquiries') }}">
                                {{ get_phrase('Inquiry') }}
                            </a>
                        </li>
                    </ul>

                </li>
            @endif

                        @if (has_permission('admin.leads.list'))
                <li
                    class="sidebar-first-li first-li-have-sub 
                {{ in_array($current_route, ['admin.leads.list', 'admin.leads.purchase']) ? 'active' : '' }}">

                    <a href="javascript:void(0);">
                        <span class="icon fi fi-sr-users-alt"></span>
                        <div class="text">
                            <span>{{ get_phrase('Leads') }}</span>
                        </div>
                    </a>

                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">
                            {{ get_phrase('Leads') }}
                        </li>

                        <li
                            class="sidebar-second-li 
                    {{ $current_route == 'admin.leads.list' ? 'active' : '' }}">
                            <a href="{{ route('admin.leads.list') }}">
                                {{ get_phrase('Manage Leads') }}
                            </a>
                        </li>

                        <li
                            class="sidebar-second-li 
                    {{ $current_route == 'admin.leads.purchase' ? 'active' : '' }}">
                            <a href="{{ route('admin.leads.purchase') }}">
                                {{ get_phrase('Leads Purchase History') }}
                            </a>
                        </li>
                    </ul>

                </li>
            @endif

            {{-- @if (has_permission('admin.team.packages'))
                <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'admin.team.packages' || $current_route == 'admin.team.packages.create' || $current_route == 'admin.team.packages.edit' || $current_route == 'admin.team.packages.purchase.history' || $current_route == 'admin.team.packages.purchase.invoice') active showMenu @endif">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-document-signed"></span>
                        <div class="text">
                            <span>{{ get_phrase('Team Training') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Team Training') }}</li>
                        <li class="sidebar-second-li @if ($current_route == 'admin.team.packages' || $current_route == 'admin.team.packages.edit') active @endif">
                            <a href="{{ route('admin.team.packages') }}">{{ get_phrase('Manage Packages') }}</a>
                        </li>
                        <li class="sidebar-second-li @if ($current_route == 'admin.team.packages.create') active @endif">
                            <a href="{{ route('admin.team.packages.create') }}">{{ get_phrase('Add New Package') }}</a>
                        </li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.team.packages.purchase.history' || $current_route == 'admin.team.packages.purchase.invoice' ? 'active' : '' }}">
                            <a href="{{ route('admin.team.packages.purchase.history') }}">{{ get_phrase('Purchase History') }}</a>
                        </li>
                    </ul>
                </li>
            @endif --}}


            @if (has_permission('admin.message'))
                <li class="sidebar-first-li {{ $current_route == 'admin.message' ? 'active' : '' }}">
                    <a href="{{ route('admin.message') }}">
                        <span class="icon fi-rr-messages"></span>
                        <div class="text">
                            <span>{{ get_phrase('Message') }}</span>
                        </div>
                        @if (
                            $unread_msg =
                                App\Models\Message::where('receiver_id', auth()->user()->id)->where('read', '')->count() > 0)
                            <span class="d-inline-block mt-2px badge bg-danger ms-auto">{{ $unread_msg }}</span>
                        @endif
                    </a>
                </li>
            @endif
            
            
            
            
            
            @if (has_permission('admin.tutor_categories'))
                <li class="d-none sidebar-first-li first-li-have-sub @if ($current_route == 'admin.tutor_subjects' || $current_route == 'admin.tutor_categories') active showMenu @endif">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-document-signed"></span>
                        <div class="text">
                            <span>{{ get_phrase('Tutor Booking') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Tutor Booking') }}</li>
                        <li class="sidebar-second-li @if ($current_route == 'admin.tutor_subjects') active @endif">
                            <a href="{{ route('admin.tutor_subjects') }}">{{ get_phrase('Subjects') }}</a>
                        </li>
                        <li class="sidebar-second-li @if ($current_route == 'admin.tutor_categories') active @endif">
                            <a href="{{ route('admin.tutor_categories') }}">{{ get_phrase('Subject Category') }}</a>
                        </li>
                    </ul>
                </li>
            @endif


            <!--@if (has_permission('admin.newsletter'))-->
            <!--    <li class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.newsletter' || $current_route == 'admin.subscribed_user' ? 'active' : '' }}">-->
            <!--        <a href="javascript:void(0);">-->
            <!--            <span class="icon fi fi-rr-envelope-open-text"></span>-->
            <!--            <div class="text">-->
            <!--                <span>{{ get_phrase('Newsletter') }}</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <ul class="first-sub-menu">-->
            <!--            <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Newsletter') }}</li>-->

            <!--            <li class="sidebar-second-li {{ $current_route == 'admin.newsletter' ? 'active' : '' }}"><a href="{{ route('admin.newsletter') }}">{{ get_phrase('Manage Newsletters') }}</a></li>-->
            <!--            <li class="sidebar-second-li {{ $current_route == 'admin.subscribed_user' ? 'active' : '' }}">-->
            <!--                <a href="{{ route('admin.subscribed_user') }}">{{ get_phrase('Subscribed User') }}</a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--@endif-->

            
            <!-- @if (has_permission('admin.products'))-->
            <!--    <li class="sidebar-first-li {{ $current_route == 'admin.products' ? 'active' : '' }}">-->
            <!--        <a href="{{ route('admin.products') }}">-->
            <!--           <span class="icon fi fi-br-comment-dots"></span>-->
            <!--            <div class="text">-->
            <!--                <span>{{ get_phrase('Products') }}</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--@endif-->


            <!--@if (has_permission('admin.consultation-services'))-->
            <!--    <li-->
            <!--        class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.consultation-services' || $current_route == 'admin.consultation-services.slots' ? 'active' : '' }}">-->
            <!--        <a href="javascript:void(0);">-->
            <!--           <span class="icon fi fi-br-user"></span>-->
            <!--            <div class="text">-->
            <!--                <span>{{ get_phrase('Consultations') }}</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <ul class="first-sub-menu">-->
                        <!--<li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('ConsultationService') }}</li>-->

            <!--            <li class="sidebar-second-li {{ $current_route == 'admin.consultation-services' ? 'active' : '' }}"><a href="{{ route('admin.consultation-services') }}">{{ get_phrase('Manage Consultation Services') }}</a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--         <ul class="first-sub-menu">-->
                        <!--<li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('ConsultationService') }}</li>-->

            <!--            <li class="sidebar-second-li {{ $current_route == 'admin.consultation-services.slots' ? 'active' : '' }}"><a href="{{ route('admin.consultation-services-slots') }}">{{ get_phrase('Manage Slots') }}</a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--@endif-->
        </ul>
    </nav>



    @if (has_permission('admin.system.settings') ||
            has_permission('admin.website.settings') ||
            has_permission('admin.payment.settings') ||
            has_permission('admin.manage.language') ||
            has_permission('admin.notification.settings') ||
            has_permission('admin.live.class.settings') ||
            has_permission('admin.certificate.settings') ||
            has_permission('admin.player.settings') ||
            has_permission('admin.open.ai.settings') ||
            has_permission('admin.pages') ||
            has_permission('admin.seo.settings') ||
            has_permission('admin.about'))
        <nav class="sidebar-nav">
            <h3 class="sidebar-title fs-12px px-30px text-uppercase pb-3">{{ get_phrase('Settings') }}</h3>
            <ul class="px-14px pb-24px mb-5 pb-5">
                <li
                    class="sidebar-first-li first-li-have-sub {{ $current_route == 'admin.system.settings' || $current_route == 'admin.website.settings' || $current_route == 'admin.language.phrase.edit' || $current_route == 'admin.payment.settings' || $current_route == 'admin.manage.language' || $current_route == 'admin.notification.settings' || $current_route == 'admin.live.class.settings' || $current_route == 'admin.certificate.settings' || $current_route == 'admin.player.settings' || $current_route == 'admin.open.ai.settings' || $current_route == 'admin.pages' || $current_route == 'admin.seo.settings' || $current_route == 'admin.about' ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-settings"></span>
                        <div class="text">
                            <span>{{ get_phrase('System Settings') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('System Settings') }}</li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.system.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.system.settings') }}">{{ get_phrase('System Settings') }}</a>
                        </li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.website.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.website.settings') }}">{{ get_phrase('Website Settings') }}</a>
                        </li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.payment.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.payment.settings') }}">{{ get_phrase('Payment Settings') }}</a>
                        </li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.manage.language' || $current_route == 'admin.language.phrase.edit' ? 'active' : '' }}">
                            <a href="{{ route('admin.manage.language') }}">{{ get_phrase('Manage Language') }}</a>
                        </li>

                        <li class="sidebar-second-li {{ $current_route == 'admin.live.class.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.live.class.settings') }}">{{ get_phrase('Live Class Settings') }}</a>
                        </li>
                        <li class="sidebar-second-li {{ $current_route == 'admin.notification.settings' ? 'active' : '' }}"><a href="{{ route('admin.notification.settings') }}">{{ get_phrase('SMTP Settings') }}</a></li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.certificate.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.certificate.settings') }}">{{ get_phrase('Certificate Settings') }}</a>
                        </li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.player.settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.player.settings') }}">{{ get_phrase('Player Settings') }}</a>
                        </li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.open.ai.settings' ? 'active' : '' }}"><a href="{{ route('admin.open.ai.settings') }}">{{ get_phrase('Open AI Settings') }}</a></li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.pages' ? 'active' : '' }}"><a href="{{ route('admin.pages') }}">{{ get_phrase('Home Page Builder') }}</a></li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.seo.settings' ? 'active' : '' }}"><a href="{{ route('admin.seo.settings') }}">{{ get_phrase('SEO Settings') }}</a></li>

                        <li class="d-none sidebar-second-li {{ $current_route == 'admin.about' ? 'active' : '' }}"><a href="{{ route('admin.about') }}">{{ get_phrase('About') }}</a></li>
                    </ul>
                </li>

                @if (has_permission('admin.manage.profile'))
                    <li class="sidebar-first-li {{ $current_route == 'admin.manage.profile' ? 'active' : '' }}">
                        <a href="{{ route('admin.manage.profile') }}">
                            <span class="icon fi-rr-circle-user"></span>
                            <div class="text">
                                <span>{{ get_phrase('Manage Profile') }}</span>
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>

<script>
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
        // Restore scroll position if it exists in localStorage
        const scrollPos = localStorage.getItem('navScrollPos');
        const sidebarNavArea = document.querySelector('.sidebar-nav-area');
        if (scrollPos) {
            sidebarNavArea.scrollTop = scrollPos;
        }

        // Ensure the active element is visible
        const activeElement = document.querySelector('.sidebar-nav-area .active');
        if (activeElement) {
            const activeElementTop = activeElement.getBoundingClientRect().top;
            const navAreaTop = sidebarNavArea.getBoundingClientRect().top;
            const navAreaBottom = navAreaTop + sidebarNavArea.clientHeight;

            if (activeElementTop < navAreaTop || activeElementTop > navAreaBottom) {
                sidebarNavArea.scrollTop = activeElement.offsetTop - sidebarNavArea.offsetTop;
            }
        }

        // Save scroll position before page unload
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('navScrollPos', sidebarNavArea.scrollTop);
        });
    });
</script>
