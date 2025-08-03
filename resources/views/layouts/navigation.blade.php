<nav id="sidebar" class="bg-gray-900 text-white h-screen flex flex-col p-4 shadow-lg transition-all duration-300 w-64">
    <!-- Botão de colapsar -->
    <button onclick="toggleSidebar()" class="absolute top-2 right-2 bg-cyan-600 text-white rounded-full p-1 shadow-md hover:bg-cyan-800 transition z-10">
        <svg id="arrowToggle" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>


  <h2 class="mb-6 text-2xl font-bold border-b border-cyan-400 pb-3 sidebar-title">Demandas</h2>

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
 

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-auto bg-red-600 rounded px-4 py-3 cursor-pointer hover:bg-red-900">
        @csrf
        <button type="submit" class="w-full text-white font-semibold">🔓 Sair</button>
    </form>
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

        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');

        texts.forEach(el => el.classList.toggle('hidden'));
        if (title) title.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');

        // Adiciona/Remove classe de deslocamento no wrapper
        wrapper.classList.toggle('pl-64');
        wrapper.classList.toggle('pl-20');
    }
</script>
