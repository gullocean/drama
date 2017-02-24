<aside id="sidebar">	
	<ul class="sidebar-inner">
	
	<li class="sidebar-item {{ Request::is('*dashboard') ? 'active' : '' }}">				
			<a href="{{ url('dashboard') }}">
                <i class="sidebar-icon fa fa-film"></i>
                <span class="sidebar-text">{{ trans('dash.titles') }}</span>
            </a>
		</li>
		
		
	<li class="sidebar-item {{ Request::is('*actors*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/actors') }}">
                <i class="sidebar-icon fa fa-user"></i>
                <span class="sidebar-text">{{ trans('main.actors') }}</span>
            </a>
		</li>
		
		<li class="sidebar-item {{ Request::is('*media*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/media') }}">
                <i class="sidebar-icon fa fa-camera-retro"></i>
                <span class="sidebar-text">{{ trans('dash.media') }}</span>
            </a>
		</li>

		
		<li class="sidebar-item {{ Request::is('*pages*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/pages') }}">
                <i class="sidebar-icon fa fa-edit"></i>
                <span class="sidebar-text">{{ trans('dash.pages') }}</span>
            </a>
		</li>


		<li class="sidebar-item {{ Request::is('*menus*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/menus') }}">
                <i class="sidebar-icon fa fa-bars"></i>
                <span class="sidebar-text">{{ trans('dash.menus') }}</span>
            </a>
		</li>

		<li class="sidebar-item {{ Request::is('*categories*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/categories') }}">
                <i class="sidebar-icon fa fa-th"></i>
                <span class="sidebar-text">{{ trans('dash.categories') }}</span>
            </a>
		</li>

		

		<li class="sidebar-item {{ Request::is('*slider*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/slider') }}">
                <i class="sidebar-icon fa fa-photo"></i>
                <span class="sidebar-text">{{ trans('dash.slider') }}</span>
            </a>
		</li>

		

	
		<li class="sidebar-item {{ Request::is('*ads*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/ads') }}">
                <i class="sidebar-icon fa fa-dollar"></i>
                <span class="sidebar-text">{{ trans('dash.ads') }}</span>
            </a>
		</li>

		@if( ! $options->disableNews())
			<li class="sidebar-item {{ Request::is('*news*') ? 'active' : '' }}">
				<a href="{{ url('dashboard/news') }}">
					<i class="sidebar-icon fa fa-bullhorn"></i>
					<span class="sidebar-text">{{ trans('main.news') }}</span>
				</a>
			</li>
		@endif

		@if( ! $options->disableReviews())
			<li class="sidebar-item {{ Request::is('*reviews*') ? 'active' : '' }}">
				<a href="{{ url('dashboard/reviews') }}">
					<i class="sidebar-icon fa fa-thumbs-up"></i>
					<span class="sidebar-text">{{ trans('main.reviews') }}</span>
				</a>
			</li>
		@endif
	
	<li class="sidebar-item {{ Request::is('*users*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/users') }}">
                <i class="sidebar-icon fa fa-users"></i>
                <span class="sidebar-text">{{ trans('main.users') }}</span>
            </a>
		</li>
		
	<li class="sidebar-item {{ Request::is('*actions*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/actions') }}">
                <i class="sidebar-icon fa fa-external-link"></i>
                <span class="sidebar-text">{{ trans('dash.actions') }}</span>
            </a>
		</li>

		
	<li class="sidebar-item {{ Request::is('*settings*') ? 'active' : '' }}">				
			<a href="{{ url('dashboard/settings') }}">
                <i class="sidebar-icon fa fa-gears"></i>
                <span class="sidebar-text">{{ trans('dash.settings') }}</span>
            </a>
		</li>
		{{ Hooks::renderHtml('Dashboard.Sidebar') }}

	</ul>
</aside>


