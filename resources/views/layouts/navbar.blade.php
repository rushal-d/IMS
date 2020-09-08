<header class="app-header navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('dashboard')}}">BMPIMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <?php
                $helper_returns = \App\Helpers\MenuHelper::allMenu();
                $allpermissions = $helper_returns->get();
                $permissions = $allpermissions->where('parent_id', null);
                ?>
                @foreach($permissions as $permission)
                    <li class="nav-item @if(count($permission->childPs) > 0 and substr($permission->menu_name, 0, 1) == "#") nav-dropdown data-toggle @endif">
                        @if(count($permission->childPs) > 0 and substr($permission->menu_name, 0, 1) == "#")
                            <a class="nav-link nav-link dropdown-toggle" data-toggle="dropdown"
                               href="{{$permission->menu_name}}">
                                <i class="{{$permission->icon}}"></i>
                                &nbsp;
                                {{$permission->display_name}}

                            </a>
                        @else
                            <a class="nav-link"
                               href="{{route($permission->menu_name)}}">
                                <i class="{{$permission->icon}}"></i>
                                &nbsp;

                                {{$permission->display_name}}

                            </a>
                        @endif
                        @if(count($permission->childPs)>0 and substr($permission->menu_name, 0, 1) == "#")
                            <?php
                            if ($permission->id > 0) {
                                $childs = $allpermissions->where('parent_id', $permission->id)
                                    ->sortBy('order');
                            }
                            ?>
                            <div class="dropdown-menu dropdown-content">
                                @foreach ($childs as $child)
                                    <a class="dropdown-item" href="{{route($child->menu_name)}}">
                                        {{ $child->display_name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>

                @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('password.request', ['token' => csrf_token()]) }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </li>
            </ul>
        </div>
    </nav>

</header>