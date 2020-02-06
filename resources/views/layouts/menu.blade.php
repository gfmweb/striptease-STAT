<ul class="metismenu" id="menu">
	<li class="nav-label">Главная</li>
	@if (Auth::user()->isAdmin())
		<li>
			<a href="{{ route('projects.statuses') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Статусы проектов</span></a>
		</li>
	@endif
	@if (!Auth::user()->isAdmin())
		<li>
			<a href="{{ route('project-data.create') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Заполнение данных</span></a>
		</li>
		<li>
			<a href="{{ route('my-projects') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Мои проекты</span></a>
		</li>
	@endif
	@if (Auth::user()->isAdmin())
		<li>
			<a href="{{ route('partners.index') }}"><i class="mdi mdi-human-male-female"></i> <span class="nav-text">Партнеры</span></a>
		</li>
		<li class="nav-label">Справочники</li>
		<li>
			<a href="{{ route('projects.index') }}"><i class="mdi mdi-settings"></i> <span class="nav-text">Проекты</span></a>
		</li>

		<li>
			<a href="{{ route('channels.index') }}"><i class="mdi mdi-key-variant"></i> <span class="nav-text">Каналы привлечения</span></a>
		</li>
	@endif
	@stack('menu-footer')
</ul>