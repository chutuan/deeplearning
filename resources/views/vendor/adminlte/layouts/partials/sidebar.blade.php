<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->full_name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <li class=""><a href="/admin"><i class='fa fa-link'></i> <span> {{ __('Dashboard') }}</span></a></li>
            <li class="treeview {{ preg_match("/OrdersController/", \Route::getCurrentRoute()->getActionName()) ? "active" : "" }}">
                <a href="#"><i class='fa fa-link'></i> <span>{{ __('Orders') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/admin/orders">{{ __('All') }}</a></li>
                    <li><a href="/admin/orders/pending-pickups">{{ __('Awaiting pick up confirmation') }}</a></li>
                    <li><a href="/admin/orders/picking">{{ __('Ready for pick-up') }}</a></li>
                    <li><a href="/admin/orders/cleaneds">{{ __('Picked-up') }}</a></li>
                    <li><a href="/admin/orders/pending-deliveries">{{ __('Awaiting delivery confirmation') }}</a></li>
                    <li><a href="/admin/orders/ready-delivery">{{ __('Ready for delivery') }}</a></li>
                    <li><a href="/admin/orders/complete">{{ __('Complete') }}</a></li>
                </ul>
            </li>
            <li class="treeview {{ preg_match("/UsersController/", \Route::getCurrentRoute()->getActionName()) ? "active" : "" }}">
                <a href="#"><i class='fa fa-link'></i> <span>{{ __('Users') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="/admin/users">{{ __('All') }}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
