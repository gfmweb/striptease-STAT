<ul class="metismenu" id="menu">
	@if(Auth::user()->isSuperAdmin())
		@include('layouts.menu.super-admin')
	@elseif(Auth::user()->isAdmin())
		@include('layouts.menu.admin')
	@else
		@include('layouts.menu.user')
	@endif

	@stack('menu-footer')
</ul>