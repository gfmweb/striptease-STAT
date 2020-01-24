<ul class="metismenu" id="menu">
    <li class="nav-label">Главная</li>
    <li>
        <a href="{{ route('project-data.create') }}"><i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Заполнение данных</span></a>
    </li>
    @stack('menu-footer')
</ul>