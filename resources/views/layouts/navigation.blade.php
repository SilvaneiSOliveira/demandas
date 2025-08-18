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
          <li class="py-1">
            <a href="{{ route('relatorios.create') }}" class="text-white hover:text-cyan-300">Criar Relatório</a>
          </li>
          <li class="py-1">
            <a href="{{ route('relatorios.graficos') }}" class="text-white hover:text-cyan-300">Dashboard</a>
          </li>
          <li class="py-1">
            <a href="{{ route('relatorios.analitico') }}" class="text-white hover:text-cyan-300">Analítico</a>
          </li>
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
    <div id="sidebarFooter" class="absolute bottom-0 left-0 w-full p-4 bg-gray-900">
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
                <span class="bg-indigo-500 text-white text-xs px-2 py-0.5 rounded">V 3.5.10</span>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white font-semibold px-3 py-1 rounded hover:bg-red-700">
                    🔓 Sair
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Scripts -->
<script>
    // Variáveis globais
let isMobile = false;
let isTablet = false;

// Detectar tamanho da tela
function detectScreenSize() {
    const width = window.innerWidth;
    isMobile = width <= 767;
    isTablet = width > 767 && width <= 1023;
}

// Inicialização quando a página carrega
document.addEventListener('DOMContentLoaded', function() {
    detectScreenSize();
    initResponsiveSidebar();
    
    // Listener para mudanças de tamanho de tela
    window.addEventListener('resize', handleResize);
});

// Inicializar sidebar responsivo
function initResponsiveSidebar() {
    const body = document.body;
    
    if (isMobile) {
        // Adicionar botão hamburger se não existir
        if (!document.querySelector('.mobile-menu-button')) {
            const hamburgerButton = createHamburgerButton();
            body.appendChild(hamburgerButton);
        }
        
        // Adicionar overlay se não existir
        if (!document.querySelector('.sidebar-overlay')) {
            const overlay = createOverlay();
            body.appendChild(overlay);
        }
    }
}

// Criar botão hamburger
function createHamburgerButton() {
    const button = document.createElement('button');
    button.className = 'mobile-menu-button';
    button.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    `;
    button.onclick = toggleMobileSidebar;
    return button;
}

// Criar overlay
function createOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    overlay.onclick = closeMobileSidebar;
    return overlay;
}

// Toggle do sidebar no mobile
function toggleMobileSidebar() {
    if (!isMobile) return;
    
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (sidebar.classList.contains('mobile-active')) {
        closeMobileSidebar();
    } else {
        openMobileSidebar();
    }
}

// Abrir sidebar mobile
function openMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.add('mobile-active');
    if (overlay) overlay.classList.add('active');
    
    // Prevenir scroll do body
    document.body.style.overflow = 'hidden';
}

// Fechar sidebar mobile
function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.remove('mobile-active');
    if (overlay) overlay.classList.remove('active');
    
    // Restaurar scroll do body
    document.body.style.overflow = '';
}

// Toggle do sidebar (função original atualizada)
function toggleSidebar() {
    // No mobile, usar função específica
    if (isMobile) {
        toggleMobileSidebar();
        return;
    }
    
    const sidebar = document.getElementById('sidebar');
    const texts = document.querySelectorAll('.sidebar-text');
    const title = document.querySelector('.sidebar-title');
    const arrow = document.getElementById('arrowToggle');
    const wrapper = document.getElementById('wrapper');
    const conteudoPrincipal = document.getElementById('conteudo-principal');
    const footer = document.getElementById('sidebarFooter'); 

    // Toggle classes do Tailwind
    sidebar.classList.toggle('w-64');
    sidebar.classList.toggle('w-20');
    sidebar.classList.toggle('collapsed');

    // Esconder/mostrar textos
    texts.forEach(el => el.classList.toggle('hidden'));
    if (title) title.classList.toggle('hidden');
    if (arrow) arrow.classList.toggle('rotate-180');

    // Ajustar margem do conteúdo principal
    if (wrapper) {
        wrapper.classList.toggle('pl-64');
        wrapper.classList.toggle('pl-20');
    }
    
    if (conteudoPrincipal) {
        conteudoPrincipal.classList.toggle('menu-colapsado');
    }

    // Controlar footer
    if (footer) {
        if (sidebar.classList.contains('collapsed')) {
            footer.classList.add('hidden');
        } else {
            footer.classList.remove('hidden');
        }
    }
}

// Toggle de submenu (função original mantida)
function toggleSubmenu(nome) {
    const submenu = document.getElementById('submenu-' + nome);
    const arrow = document.getElementById('arrow-' + nome);

    if (submenu && arrow) {
        submenu.classList.toggle('hidden');
        arrow.style.transform = submenu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
    }
}

// Gerenciar redimensionamento da tela
function handleResize() {
    const wasMobile = isMobile;
    detectScreenSize();
    
    // Se mudou de mobile para desktop ou vice-versa
    if (wasMobile !== isMobile) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const hamburger = document.querySelector('.mobile-menu-button');
        
        if (isMobile) {
            // Mudou para mobile
            sidebar.classList.remove('collapsed', 'w-20');
            sidebar.classList.add('w-64');
            closeMobileSidebar();
            initResponsiveSidebar();
        } else {
            // Mudou para desktop
            sidebar.classList.remove('mobile-active');
            if (overlay) overlay.classList.remove('active');
            if (hamburger) hamburger.style.display = 'none';
            document.body.style.overflow = '';
            
            // Restaurar estado normal do sidebar
            const conteudoPrincipal = document.getElementById('conteudo-principal');
            if (conteudoPrincipal) {
                conteudoPrincipal.classList.remove('menu-colapsado');
            }
        }
    }
}

// Fechar sidebar ao clicar em links (apenas no mobile)
document.addEventListener('click', function(e) {
    if (isMobile && e.target.tagName === 'A' && e.target.closest('#sidebar')) {
        setTimeout(closeMobileSidebar, 100);
    }
});

// Fechar sidebar com tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isMobile) {
        closeMobileSidebar();
    }
});

</script>


