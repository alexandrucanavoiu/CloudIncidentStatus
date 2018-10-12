<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <div class="report-an-incident-button center-block"><button class="btn btn-block btn-warning add-incidents" href="" data-toggle="modal" data-target="#myModal-Incidents-add">REPORT AN INCIDENT</button></div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.dashboard']) }}">
                <a href="{{ route('authenticated.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.incidents', 'authenticated.incidents.update.index']) }}"><a href="{{ route('authenticated.incidents') }}">
                    <i class="fa fa-info-circle"></i> <span>Incidents</span></a>
            </li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.schedule']) }}"><a href="{{ route('authenticated.schedule') }}">
                <i class="fa fa-bell"></i> <span>Scheduled Maintenance</span></a>
            </li>
            <li class="header">MANAGE</li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.templates']) }}"><a href="{{ route('authenticated.templates') }}"><i class="fa fa-sticky-note-o"></i> <span>Incident Templates</span></a></li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.components']) }}"><a href="{{ route('authenticated.components') }}"><i class="fa fa-cogs"></i> <span>Components List</span></a></li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.components.groups']) }}"><a href="{{ route('authenticated.components.groups') }}"><i class="fa fa-object-group"></i> <span>Component Groups</span></a></li>
            <li class="header">Admin</li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.subscribes']) }}"><a href="{{ route('authenticated.subscribes') }}"><i class="fa fa-calendar"></i> <span>Subscribers</span></a></li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.failedjobs']) }}"><a href="{{ route('authenticated.failedjobs') }}"><i class="fa fa-bug"></i> <span>Failed Jobs</span></a></li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.users']) }}"><a href="{{ route('authenticated.users') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['authenticated.settings']) }}"><a href="{{ route('authenticated.settings') }}"><i class="fa fa-wrench"></i> <span>Settings</span></a></li>
            <li class="header">User</li>
            <li class="{{ \App\Helpers\Navigation::isActiveRoute(['logout']) }}"><a href="{{ route('logout') }}"><i class="fa  fa-power-off"></i> <span>Log Out</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
