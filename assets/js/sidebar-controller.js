/**
 * Amura OS - Sidebar State Controller
 *
 * Problema raiz: em diferentes breakpoints, a classe .open no #sidebar
 * tem significados opostos. Além disso, o CSS hardcoded de 270px como
 * margem causava gap excessivo em telas onde o sidebar expandido é 200px.
 *
 * Solução: ler a largura REAL do sidebar em px e aplicar diretamente como
 * margin-left em .navebarn e #content, mantendo sincronismo perfeito.
 *
 * Classes aplicadas no body:
 *  - body.sidebar-expanded  → sidebar com texto visível (>120px)
 *  - body.sidebar-collapsed → sidebar apenas com ícones (<=120px)
 */
(function () {
  'use strict';

  var THRESHOLD = 120; // px — abaixo = colapsado, acima = expandido

  function applyLayout() {
    var sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    var sidebarWidth = sidebar.offsetWidth;
    var body         = document.body;
    var navebarn     = document.querySelector('.navebarn');
    var content      = document.getElementById('content');

    // Aplica classes semanticas no body (usadas pelo CSS para controlar a logo)
    if (sidebarWidth > THRESHOLD) {
      body.classList.add('sidebar-expanded');
      body.classList.remove('sidebar-collapsed');
    } else {
      body.classList.add('sidebar-collapsed');
      body.classList.remove('sidebar-expanded');
    }

    // Aplica margem exata = largura real do sidebar
    // Isso elimina gaps e barra de rolagem horizontal desnecessaria
    var marginValue = sidebarWidth + 'px';

    if (navebarn) {
      navebarn.style.setProperty('margin-left', marginValue, 'important');
    }

    if (content) {
      content.style.setProperty('margin-left', marginValue, 'important');
    }
  }

  function watchSidebar() {
    var sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    // Detectar imediatamente ao carregar
    applyLayout();

    // Observar redimensionamentos (triggered por toggles CSS)
    if (window.ResizeObserver) {
      var observer = new ResizeObserver(function () {
        applyLayout();
      });
      observer.observe(sidebar);
    } else {
      // Fallback: escuta o clique no botão de toggle
      var toggleBtn = sidebar.querySelector('a.visible-phone');
      if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
          setTimeout(applyLayout, 450);
        });
      }
      window.addEventListener('resize', applyLayout);
    }
  }

  // Inicializa quando o DOM estiver pronto
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', watchSidebar);
  } else {
    watchSidebar();
  }
})();

