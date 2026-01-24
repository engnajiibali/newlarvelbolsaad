<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ url('dashboard') }}" class="logo logo-normal">
            <img src="{{ asset('/assets/img/pologo.png') }}" alt="Logo">
        </a>
        <a href="{{ url('dashboard') }}" class="logo-small">
            <img src="{{ asset('/assets/img/pologo.png') }}" alt="Logo">
        </a>
        <a href="{{ url('dashboard') }}" class="dark-logo">
            <img src="{{ asset('/assets/img/pologo.png') }}" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->
<br>

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <br>
             <br>
            <ul>
                <li class="menu-title"><span>MAIN MENU</span></li>
                <li>
                    <ul>
                        <li>
                            <a href="{{ url('dashboard') }}">
                                <i class="ti ti-smart-home"></i><span>Dashboard</span>
                            </a>
                        </li>

                        @foreach(getMenu() as $menu)
                            @php
                                $allowedSubmenus = allowedSubmenus(Session()->get('userRole'));
                                $submenus = $menu->subMenus->filter(function($subMenu) use ($allowedSubmenus) {
                                    return in_array($subMenu->id, $allowedSubmenus);
                                });
                            @endphp

                            @if($submenus->isNotEmpty())
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="{{ $menu->icon }}"></i><span>{{ $menu->menu_name }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        @foreach($submenus as $subMenu)
                                            <li>
                                                <a href="{{ url($subMenu->url) }}" target="{{ $subMenu->target }}" title="{{ $subMenu->title }}">
                                                    <i class="fa fa-circle-o"></i> {{ $subMenu->icon . ' ' . $subMenu->name_sub_menu }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
