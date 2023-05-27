
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <p class="sidebar-brand" >
            <span class="align-middle">{{$systemSetting['shortName']}}</span>
        </p>
        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href=" {{ route('dashboard') }}  ">
                    <i class="align-middle fa-solid fa-house"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('invoice') ? 'active' : '' }}">
                <a class="sidebar-link" href=" {{ route('invoice') }}  ">
                    <i class="align-middle fa-regular fa fa-usd"></i> <span class="align-middle">Invoice</span>
                </a>
            </li>
        </ul>
    </div>
</nav>