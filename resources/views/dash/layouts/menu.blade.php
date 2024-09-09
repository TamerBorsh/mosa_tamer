<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{route('dash.index')}}"><i class="la la-dashboard"></i><span class="menu-title">الرئيسية</span></a>
            </li>
            {{-- @can('Read-Admins') --}}
            <li class=" nav-item"><a href="{{route('admins.index')}}"><i class="la la-user-plus"></i><span class="menu-title">الموظفين</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Read-Roles') --}}
            <li class=" nav-item"><a href="{{route('roles.index')}}"><i class="la la-group"></i><span class="menu-title">الأدوار</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Read-Institutions') --}}
            <li class=" nav-item"><a href="{{route('institutions.index')}}"><i class="la la-lock"></i><span class="menu-title">المؤسسات</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Read-Coupons') --}}
            <li class=" nav-item"><a href="{{route('coupons.index')}}"><i class="la la-lock"></i><span class="menu-title">الأصناف</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Read-Locations') --}}
            <li class=" nav-item"><a href="{{route('locations.index')}}"><i class="la la-lock"></i><span class="menu-title">المخازن والبركسات</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Read-Mosques') --}}
            <li class=" nav-item"><a href="{{route('mosques.index')}}"><i class="la la-lock"></i><span class="menu-title">المعالم</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @can('Redemption') --}}
            <li class=" nav-item"><a href="{{route('nominates.couponRedemption')}}"><i class="la la-undo"></i><span class="menu-title" data-i18n="Hospital">صرف الكابون</span></a>
            </li>
            {{-- @endcan --}}
            {{-- @canany(['Read-Users', 'Create-User']) --}}
            <li class=" nav-item"><a href="javascript:;"><i class="la la-user"></i><span class="menu-title">المستفيدين</span></a>
                <ul class="menu-content">
                    {{-- @can('Read-Users') --}}
                    <li><a class="menu-item" href="{{route('users.index')}}"><i></i><span>عرض الجميع</span></a>
                    </li>
                    {{-- @endcan --}}
                    {{-- @can('Create-User') --}}
                    <li><a class="menu-item" href="{{route('users.create')}}"><i></i><span>أضف مستفيد جديد</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('users.importExcelForm')}}"><i></i><span>استيراد Excel</span></a>
                    </li>
                    {{-- @endcan --}}
                </ul>
            </li>
            {{-- @endcanany --}}
            {{-- @canany(['Read-Nominates', 'Create-Nominate']) --}}
            <li class=" nav-item"><a href="javascript:;"><i class="la la-print"></i><span class="menu-title">المرشحين</span></a>
                <ul class="menu-content">
                    {{-- @can('Read-Nominates') --}}
                    <li><a class="menu-item" href="{{route('nominates.index')}}"><i></i><span>عرض الجميع</span></a></li>
                    {{-- @endcan --}}
                    @can('Create-Nominate')
                    <li><a class="menu-item" href="{{route('nominates.create')}}"><i></i><span>شاشة الترشيح</span></a></li>
                    {{-- @endcan --}}
                    {{-- @can('Update-Nominate') --}}
                    <li><a class="menu-item" href="{{route('nominates.importExcelForm')}}"><i></i><span>تحديث حالة المستفيد Excel</span></a>
                    </li>
                    {{-- @endcan --}}
                    @can('Create-Nominate')<li><a class="menu-item" href="{{route('nominates.importNominatesForm')}}"><i></i><span>استيراد ملف ترشيح</span></a>
                    </li>
                    {{-- @endcan --}}
                </ul>
            </li>
            {{-- @endcanany --}}
            {{-- @can('Logs') --}}
            <li class=" nav-item"><a href="{{route('logs.index')}}"><i class="la la-undo"></i><span class="menu-title" data-i18n="Hospital">أخطاء النظام</span></a>
            </li>
            {{-- @endcan --}}
            <li class=" nav-item"><a href="{{route('users.problem')}}"><i class="la la-undo"></i><span class="menu-title" data-i18n="Hospital">الشكاوي</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('auth.logout')}}"><i class="la la-undo"></i><span class="menu-title" data-i18n="Hospital">تسجيل الخروج</span></a>
            </li>
        </ul>
    </div>
</div>
<style>
    i.toggle-icon.font-medium-3.white.ft-toggle-right {
        color: #fff;
    }
</style>