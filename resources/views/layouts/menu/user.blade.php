<li class="nav-label">Данные</li>

<li><a href="{{ route('user-target-data.create') }}"><i class="mdi mdi-table-edit"></i> <span class="nav-text">Данные по проектам</span></a></li>

<li class="nav-label">Проекты</li>

<li>
	<a @if (Auth::user()->subProjects->count()) href="{{ route('my-projects') }}" @endif>
		<i class="mdi mdi-view-dashboard"></i>
		<span class="nav-text">Мои проекты</span>
		<span class="badge badge-primary nav-badge">{{ Auth::user()->subProjects->count() }}</span>
	</a>
</li>
