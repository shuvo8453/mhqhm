
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <p class="sidebar-brand" >
            <span class="align-middle">{{$systemSetting['shortName']}}</span>
        </p>
        <ul class="sidebar-nav">
            @foreach( $menus as $menu )
                @if(count($menu->subMenu) == 0 && !empty($menu->route))
                    @php
                        $permissionName = explode(".",$menu->route);
                        $permission = $permissionName[1] . " " . $permissionName[0];
                    @endphp
                    @if(Auth::guard('admin')->user()->can($permission) )
                        <li class="sidebar-item {{ request()->routeIs($menu->route) ? 'active' : '' }}">
                            <a class="sidebar-link" href=" {{ route($menu->route) }}  ">
                                <i class="align-middle {{ $menu->icon }}"></i> <span class="align-middle">{{$menu->title}}</span>
                            </a>
                        </li>
                    @endif
                @elseif(count($menu->subMenu) > 0 )
                    <li class="sidebar-item ">
                        @php
                            $pNames = explode(' ',$menu->title);
                            $pName = $pNames[0];
                        @endphp
                        <a data-bs-target="#{{ $pName }}" data-bs-toggle="collapse" class="sidebar-link">
                            <i class="align-middle {{ $menu->icon }}"></i> <span class="align-middle">{{$menu->title}}</span>
                        </a>
                        <ul id="{{$pName}}" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            @foreach( $menu->subMenu as $sub )
                                @php
                                    $permissionName = explode(".",$sub->route);
                                    $permission = $permissionName[1] . " " . $permissionName[0];
                                @endphp
                                @if(Auth::guard('admin')->user()->can($permission) )
                                    <li class="sidebar-item {{ request()->routeIs($sub->route) ? 'active' : '' }}">
                                        <a class="sidebar-link" href=" {{ route($sub->route) }}  ">
                                            <i class="align-middle {{ $sub->icon }}"></i> <span class="align-middle">{{$sub->title}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>