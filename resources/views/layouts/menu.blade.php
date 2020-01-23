<ul class="metismenu" id="menu">
	<li class="nav-label">Главная</li>
	<li>
		<a href="{{ route('home') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Клиенты</span><span class="badge badge-success nav-badge">3</span></a>
	</li>
	@stack('menu-footer')
</ul>