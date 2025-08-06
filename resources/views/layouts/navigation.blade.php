<nav id="sidebar" class="relative bg-gray-900 text-white h-screen flex flex-col p-4 shadow-lg transition-all duration-300 w-64">
    <!-- Botão de colapsar -->
    <button onclick="toggleSidebar()" class="absolute top-2 right-2 bg-cyan-600 text-white rounded-full p-1 shadow-md hover:bg-cyan-800 transition z-10">
        <svg id="arrowToggle" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
<div class="flex-1 overflow-y-auto">

   <h2 class="mt-6 mb-6 text-2xl font-bold border-b border-cyan-400 pb-3 sidebar-title">Demandas</h2>


   <ul class="list-none flex flex-col gap-2">
        <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500">
            <a href="{{ route('home') }}" class="block text-white hover:text-cyan-300">
                <span class="mr-2">🏠</span> <span class="sidebar-text">HOME</span>
            </a>
        </li>

      {{-- CLIENTES --}}
      <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('clientes')">
        <div class="flex justify-between items-center">
          <span><span class="mr-2">👥</span> <span class="sidebar-text">CLIENTES</span></span>
          <span id="arrow-clientes" class="transition-transform duration-300">></span>
        </div>
        <ul id="submenu-clientes" class="list-none pl-5 mt-1 hidden">
          <li class="py-1"><a href="{{ route('clientes.create') }}" class="text-white hover:text-cyan-300">Cadastrar Cliente</a></li>
          <li class="py-1"><a href="{{ route('clientes.index') }}" class="text-white hover:text-cyan-300">Consultar Cliente</a></li>
        </ul>
      </li>

      {{-- FILIAIS --}}
      <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('filiais')">
        <div class="flex justify-between items-center">
          <span><span class="mr-2">🏢</span> <span class="sidebar-text">FILIAIS</span></span>
          <span id="arrow-filiais" class="transition-transform duration-300">></span>
        </div>
        <ul id="submenu-filiais" class="list-none pl-5 mt-1 hidden">
          <li class="py-1"><a href="{{ route('filiais.create') }}" class="text-white hover:text-cyan-300">Cadastrar Filial</a></li>
          <li class="py-1"><a href="{{ route('filiais.index') }}" class="text-white hover:text-cyan-300">Consultar Filial</a></li>
        </ul>
      </li>

      {{-- DEMANDAS --}}
      <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('demandas')">
        <div class="flex justify-between items-center">
          <span><span class="mr-2">📋</span> <span class="sidebar-text">DEMANDAS</span></span>
          <span id="arrow-demandas" class="transition-transform duration-300">></span>
        </div>
        <ul id="submenu-demandas" class="list-none pl-5 mt-1 hidden">
          <li class="py-1"><a href="{{ route('demandas.create') }}" class="text-white hover:text-cyan-300">Cadastrar Demanda</a></li>
          <li class="py-1"><a href="{{ route('demandas.index') }}" class="text-white hover:text-cyan-300">Consultar Demanda</a></li>
        </ul>
      </li>

      {{-- RELATÓRIOS --}}
      <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('relatorios')">
        <div class="flex justify-between items-center">
          <span><span class="mr-2">📊</span> <span class="sidebar-text">RELATÓRIOS</span></span>
          <span id="arrow-relatorios" class="transition-transform duration-300">></span>
        </div>
        <ul id="submenu-relatorios" class="list-none pl-5 mt-1 hidden">
          <li class="py-1"><a href="{{ route('relatorios.create') }}" class="text-white hover:text-cyan-300">Criar Relatório</a></li>
          <li class="py-1"><a href="{{ route('relatorios.graficos') }}" class="text-white hover:text-cyan-300">Dashboard</a></li>
        </ul>
      </li>

      {{-- TOMBAMENTOS --}}
      <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('tombamentos')">
        <div class="flex justify-between items-center">
          <span><span class="mr-2">🛠️</span> <span class="sidebar-text">TOMBAMENTOS</span></span>
          <span id="arrow-tombamentos" class="transition-transform duration-300">></span>
        </div>
        <ul id="submenu-tombamentos" class="list-none pl-5 mt-1 hidden">
          <li class="py-1"><a href="{{ route('tombamentos.preventivas') }}" class="text-white hover:text-cyan-300">Preventivas</a></li>
          <li class="py-1"><a href="{{ route('tombamentos.computadores') }}" class="text-white hover:text-cyan-300">Computadores</a></li>
        </ul>
      </li>

      {{-- USUÁRIOS (admin) --}}
      @auth
        @if (Auth::user()->tipo === 'admin')
          <li class="cursor-pointer rounded px-3 py-2 hover:bg-cyan-500" onclick="toggleSubmenu('users')">
            <div class="flex justify-between items-center">
              <span><span class="mr-2">👤</span> <span class="sidebar-text">USUÁRIOS</span></span>
              <span id="arrow-users" class="transition-transform duration-300">></span>
            </div>
            <ul id="submenu-users" class="list-none pl-5 mt-1 hidden">
              <li class="py-1"><a href="{{ route('users.create') }}" class="text-white hover:text-cyan-300">Criar Usuários</a></li>
              <li class="py-1"><a href="{{ route('users.index') }}" class="text-white hover:text-cyan-300">Gerenciar Usuários</a></li>
            </ul>
          </li>
        @endif
      @endauth
   </ul>
  
   {{-- RODAPÉ --}}
    <div id="sidebarFooter" class="absolute bottom-0 left-0 w-full p-4 bg-gray-800">
        <div class="text-sm text-gray-300">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-base">👤</span>
                <span class="truncate">{{ Auth::user()->name }}</span>
                <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded">
                    {{ strtoupper(Auth::user()->tipo) }}
                </span>
            </div>
            <div class="flex items-center gap-2 mb-2">
                <span class="text-base">📘</span>
                <span class="truncate">Sistema Demandas</span>
                <span class="bg-indigo-500 text-white text-xs px-2 py-0.5 rounded">V 1.2.0</span>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-600 text-white font-semibold px-3 py-2 rounded hover:bg-red-900">
                    🔓 Sair
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Scripts -->
<script>
    function toggleSubmenu(nome) {
      const submenu = document.getElementById('submenu-' + nome);
      const arrow = document.getElementById('arrow-' + nome);

      submenu.classList.toggle('hidden');
      arrow.style.transform = submenu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
    }

    function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.sidebar-text');
    const title = document.querySelector('.sidebar-title');
    const arrow = document.getElementById('arrowToggle');
    const wrapper = document.getElementById('wrapper');
    const footer = document.getElementById('sidebarFooter'); 

    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-20');
    
    // ADICIONA OU REMOVE A CLASSE collapsed 
    sidebar.classList.toggle('collapsed');

    texts.forEach(el => el.classList.toggle('hidden'));
    if (title) title.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');

    wrapper.classList.toggle('pl-64');
    wrapper.classList.toggle('pl-20');

    // ESCONDE O RODAPÉ JUNTO COM A SIDEBAR
    if (sidebar.classList.contains('collapsed')) {
        footer.classList.add('hidden');
    } else {
        footer.classList.remove('hidden');
    }
}

</script>
