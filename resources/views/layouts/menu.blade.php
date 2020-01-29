<ul class="metismenu" id="menu">
    <li class="nav-label">Главная</li>
    <li>
        <a href="{{ route('project-data.create') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Заполнение данных</span></a>
    </li>
    <li class="nav-label">Справочники</li>
    <li>
        <a href="{{ route('channels.index') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Каналы</span></a>
    </li>
    @stack('menu-footer')
</ul>