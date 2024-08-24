<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class=" nav-item"><a href="{{route('dash.index')}}"><i class="la la-dashboard"></i><span class="menu-title">الرئيسية</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('admins.index')}}"><i class="la la-user-plus"></i><span class="menu-title">الموظفين</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('roles.index')}}"><i class="la la-group"></i><span class="menu-title">الأدوار</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('institutions.index')}}"><i class="la la-lock"></i><span class="menu-title">المؤسسات</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('coupons.index')}}"><i class="la la-lock"></i><span class="menu-title">الكابون</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('locations.index')}}"><i class="la la-lock"></i><span class="menu-title">المخازن والبركسات</span></a>
            </li>
            <li class=" nav-item"><a href="{{route('mosques.index')}}"><i class="la la-lock"></i><span class="menu-title">المساجد</span></a>
            </li>


            <li class=" nav-item"><a href="javascript:;"><i class="la la-user"></i><span class="menu-title">المستفيدين</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('users.index')}}"><i></i><span>عرض الكل</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('users.create')}}"><i></i><span>أضف جديد</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('users.create')}}"><i></i><span>تقديم طلب للاضافة</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('users.importExcelForm')}}"><i></i><span>استيراد Excel</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="javascript:;"><i class="la la-print"></i><span class="menu-title">المرشحين</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('nominates.index')}}"><i></i><span>عرض الكل</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('nominates.importExcelForm')}}"><i></i><span>تحديث حالة المستفيد Excel</span></a>
                    </li>
                    <li><a class="menu-item" href="{{route('nominates.importNominatesForm')}}"><i></i><span>استيراد ملف ترشيح</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="{{route('auth.logout')}}"><i class="la la-undo"></i><span class="menu-title" data-i18n="Hospital">تسجيل الخروج</span></a>
            </li>
        </ul>
    </div>
</div>