// portfolio.js — Versão completa que intercepta envio do form (AJAX) e evita navegação
// Cole este arquivo em portfolio.js e inclua <script src="portfolio.js" defer></script> antes do </body>

(function () {
  'use strict';

  /* -------------------------
     Utilitários e UI helpers
     ------------------------- */
  function showStatus(container, html) {
    if (!container) return;
    container.innerHTML = html;
  }

  function getStatusEl(form) {
    // procura por um status dentro do form primeiro, senão cria um depois do form
    let status = form.querySelector('.form-status') || document.getElementById('form-status');
    if (!status) {
      status = document.createElement('div');
      status.id = 'form-status';
      status.className = 'form-status';
      status.style.marginTop = '12px';
      form.parentNode.insertBefore(status, form.nextSibling);
    }
    return status;
  }

  function cleanHtmlText(s) {
    return String(s).replace(/<[^>]*>/g, '').trim();
  }

  /* -------------------------
     AJAX submit principal
     ------------------------- */
  async function ajaxSubmit(form) {
    const statusEl = getStatusEl(form);
    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
    const origText = submitBtn ? submitBtn.innerHTML : null;

    try {
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Enviando...';
      }

      const url = form.action || 'enviar_email.php';
      const fd = new FormData(form);

      const res = await fetch(url, {
        method: 'POST',
        body: fd,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'text/html'
        }
      });

      const text = await res.text();

      if (res.ok && text.includes('Mensagem enviada com sucesso')) {
        showStatus(statusEl, '<div class="form-success">Mensagem enviada com sucesso ✅</div>');
        try { form.reset(); } catch (e) {}
      } else {
        let msg = 'Erro ao enviar a mensagem.';
        const h2 = text.match(/<h2[^>]*>([^<]+)<\/h2>/i);
        const li = text.match(/<li>(.*?)<\/li>/i);
        if (h2) msg = cleanHtmlText(h2[1]);
        else if (li) msg = cleanHtmlText(li[1]);
        else if (!res.ok) msg = `Erro HTTP: ${res.status}`;
        showStatus(statusEl, '<div class="form-error">' + msg + '</div>');
      }
    } catch (err) {
      showStatus(statusEl, '<div class="form-error">Erro de rede: ' + (err && err.message ? err.message : err) + '</div>');
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = origText;
      }
    }
  }

  /* -------------------------
     Bind de forms existentes
     ------------------------- */
  function bindForm(form) {
    if (!form) return;
    // evita double-bind
    if (form.dataset.ajaxBound === '1') return;
    form.dataset.ajaxBound = '1';

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      ajaxSubmit(form);
    }, { capture: true });
  }

  /* -------------------------
     Intercepta chamadas programáticas form.submit()
     ------------------------- */
  (function interceptProgrammaticSubmit() {
    const originalSubmit = HTMLFormElement.prototype.submit;
    HTMLFormElement.prototype.submit = function () {
      // dispara evento submit cancelável
      const evt = new Event('submit', { cancelable: true });
      if (this.dispatchEvent(evt)) {
        // se não for cancelado, usa ajaxSubmit ao invés da navegação
        ajaxSubmit(this);
      }
      // não chamamos originalSubmit() para evitar navegação padrão
      // se você quiser permitir navegação em casos específicos, remova esse comportamento
    };
    // caso precise restaurar originalSubmit em runtime, guarde originalSubmit em outro lugar
  })();

  /* -------------------------
     DOMContentLoaded principal
     ------------------------- */
  document.addEventListener('DOMContentLoaded', function () {
    // — manutenção de comportamentos existentes (ex.: ano dinâmico, nav toggle)
    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    const navToggle = document.getElementById('navToggle');
    const mobileNav = document.getElementById('mobileNav');
    function toggleNav() {
      const open = document.body.classList.toggle('nav-open');
      if (mobileNav) mobileNav.setAttribute('aria-hidden', String(!open));
    }
    if (navToggle) navToggle.addEventListener('click', toggleNav);

    window.addEventListener('resize', () => {
      if (window.innerWidth > 880 && document.body.classList.contains('nav-open')) {
        document.body.classList.remove('nav-open');
        if (mobileNav) mobileNav.setAttribute('aria-hidden', 'true');
      }
    });

    // — bind para todos os forms já na página
    const forms = document.querySelectorAll('form');
    forms.forEach(f => bindForm(f));
  });

  /* -------------------------
     Segurança extra: observa novos forms adicionados dinamicamente
     ------------------------- */
  (function observeNewForms() {
    if (!window.MutationObserver) return;
    const observer = new MutationObserver((mutations) => {
      for (const m of mutations) {
        for (const node of m.addedNodes) {
          if (!(node instanceof HTMLElement)) continue;
          if (node.tagName === 'FORM') bindForm(node);
          // também busca forms dentro do nó adicionado
          const innerForms = node.querySelectorAll ? node.querySelectorAll('form') : [];
          innerForms.forEach(f => bindForm(f));
        }
      }
    });
    observer.observe(document.documentElement || document.body, { childList: true, subtree: true });
  })();

})();
