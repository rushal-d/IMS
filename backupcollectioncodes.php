<ul class="nav">
    <li class="nav-item">
        <a id="maindash" class="nav-link" href="{{('/dashboard')}}">
            <i class="nav-icon icon-speedometer"></i> Dashboard
        </a>
    </li>
    <li class="divider"></li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('bond.index')}}">
            <i class="nav-icon icon-control-start"></i> Bond
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('deposit.index')}}">
            <i class="nav-icon icon-control-start"></i> Deposit
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('share.index')}}">
            <i class="nav-icon icon-control-start"></i> Share
        </a>
    </li>
    <li class="divider"></li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-star"></i>Settings</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link" href="{{route('fiscalyear.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Fiscal Year</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('userorganization.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Organization</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('bankbranch.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Bank's Branches</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('investmenttype.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Investment Sector</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('investmentgroup.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Investment Groups</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('bonds.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Bond SetUp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('deposits.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Deposit SetUp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('shares.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Share SetUp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('share.market')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Today's Share Market</a>
            </li>
        </ul>
    </li>
    <li class="divider"></li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-star"></i>User Management</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item">
                <a class="nav-link" href="{{route('role.index')}}" target="_top">
                    <i class="nav-icon icon-star"></i>Roles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user.index')}}" target="_top">
                    <i class="nav-icon icon-user"></i>Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('permission.index')}}" target="_top">
                    <i class="nav-icon icon-check"></i>Permission</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('assignrole.index')}}" target="_top">
                    <i class="nav-icon icon-user-follow"></i>Assign Permission to Role</a>
            </li>

        </ul>
    </li>
</ul>