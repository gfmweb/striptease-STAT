<ul class="metismenu" id="menu">
	<li class="nav-label">Данные</li>
	<li>
		<a href="{{ route('user-target-data.create') }}"><i class="mdi mdi-table-edit"></i> <span class="nav-text">Заполнение данных</span></a>
	</li>
	<li>
		<a href="{{ route('password-city-data.create') }}"><i class="mdi mdi-table-edit"></i> <span class="nav-text">Данные по паролям</span></a>
	</li>
	<li class="nav-label">Проекты</li>
	<li>
		<a @if (Auth::user()->subProjects->count()) href="{{ route('my-projects') }}" @endif>
			<i class="mdi mdi-view-dashboard"></i>
			<span class="nav-text">Мои проекты</span>
			<span class="badge badge-primary nav-badge">{{ Auth::user()->subProjects->count() }}</span>
		</a>
	</li>
	@if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
		<li>
			<a href="{{ route('projects.statuses') }}"><i class="mdi mdi-calendar-check"></i> <span class="nav-text">Статусы проектов</span></a>
		</li>
		<li class="nav-label">Отчеты</li>
		<li>
			<a href="{{ route('reports.main') }}"><i class="ion-android-list"></i><span class="nav-text">Отчет по партнерам</span></a>
		</li>
		<li class="nav-label">Справочники</li>
		<li>
			<a href="{{ route('partners.index') }}"><i class="mdi mdi-human-male-female"></i> <span class="nav-text">Партнеры</span></a>
		</li>
		<li>
			<a href="{{ route('projects.index') }}"><i class="mdi mdi-settings"></i> <span class="nav-text">Проекты</span></a>
		</li>
		<li>
			<a href="{{ route('channels.index') }}"><i class="mdi mdi-sitemap"></i> <span class="nav-text">Каналы привлечения</span></a>
		</li>
	@endif
	@if (Auth::user()->isSuperAdmin())
		<li>
			<a href="{{ route('passwords.index') }}"><i class="mdi mdi-key-variant"></i> <span class="nav-text">Пароли</span></a>
		</li>
	@endif
	@stack('menu-footer')
</ul>