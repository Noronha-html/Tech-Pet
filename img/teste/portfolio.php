<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dev16 — Agência de Desenvolvimento</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./portfolio.css" />
  </head>
  <body>
    <div class="wrap">
      <header>
        <div style="display: flex; align-items: center; gap: 12px">
          <button class="nav-toggle" aria-label="Abrir menu" id="navToggle">
            ☰
          </button>
          <div class="brand">Dev16</div>
        </div>
        <nav aria-label="menu" id="mainNav">
          <a href="#services">Serviços</a>
          <a href="#tech">Tecnologias</a>
          <a href="#projects">Projetos</a>
          <a href="#about">Sobre Nós</a>
          <a class="btn-cta" href="#contact">Solicitar Orçamento</a>
        </nav>
      </header>

      <div class="nav-mobile" id="mobileNav" aria-hidden="true">
        <a href="#services" onclick="toggleNav()">Serviços</a>
        <a href="#tech" onclick="toggleNav()">Tecnologias</a>
        <a href="#projects" onclick="toggleNav()">Projetos</a>
        <a href="#about" onclick="toggleNav()">Sobre Nós</a>
        <a class="btn-cta" href="#contact" onclick="toggleNav()"
          >Solicitar Orçamento</a
        >
      </div>

      <main>
        <section class="hero">
          <div class="hero-inner">
            <h1>Somos Desenvolvedores<br/>Web & UI Designers</h1>
            <p class="lead">
              Três jovens apaixonados por tecnologia, criando soluções digitais
              para pequenas empresas. Atuamos com sites institucionais, lojas
              online e interfaces funcionais.
            </p>

            <div class="stats" role="list">
              <div class="stat" role="listitem">
                <b>50+</b><span>Clientes</span>
              </div>
              <div class="stat" role="listitem">
                <b>20+</b><span>Projetos</span>
              </div>
              <div class="stat" role="listitem">
                <b>10+</b><span>Tecnologias</span>
              </div>
            </div>
          </div>

          <div class="hero-right">
            <div class="team-badge-wrap" aria-hidden="true">
              <div class="team-badge" aria-hidden="true">
                <svg
                  viewBox="0 0 64 64"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    d="M32 6c14.36 0 26 11.64 26 26S46.36 58 32 58 6 46.36 6 32 17.64 6 32 6zm0 6a9 9 0 100 18 9 9 0 000-18zm0 34c8.84 0 16-3.58 16-8v-2c0-3.31-7.16-6-16-6s-16 2.69-16 6v2c0 4.42 7.16 8 16 8z"
                  />
                </svg>
              </div>
            </div>
          </div>
        </section>

        <section id="services" aria-labelledby="services-title">
          <h2 class="section-title" id="services-title">Serviços</h2>

          <p style="color:var(--muted);max-width:900px">
            Oferecemos soluções web pensadas para pequenas empresas: sites institucionais, lojas online simples,
            manutenção e otimização. Entregamos projetos rápidos, com boa usabilidade e foco em conversão.
          </p>

          <div class="services-grid" role="list">
            <article class="service-card" role="listitem">
              <svg class="service-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="14" rx="2"/></svg>
              <h3>Sites empresariais</h3>
              <p>Landing pages e sites empresariais otimizados para apresentar sua empresa e captar clientes.</p>
              <small>Entrega rápida • Design responsivo</small>
            </article>

            <article class="service-card" role="listitem">
              <svg class="service-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18v2H3zM5 10h14v9H5z"/></svg>
              <h3>E-commerce Básico</h3>
              <p>Loja online com catálogo, carrinho e checkout integrado — ideal para pequenos comércios.</p>
              <small>Integração com meios de pagamento • Treinamento básico</small>
            </article>

            <article class="service-card" role="listitem">
              <svg class="service-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z"/></svg>
              <h3>Design UI/UX & Prototipagem</h3>
              <p>Prototipagem e interface pensada em fluidez para o usuário — testamos fluxos simples que aumentam a acessibilidade do site.</p>
              <small>Wireframes • Protótipos interativos</small>
            </article>

            <article class="service-card" role="listitem">
              <svg class="service-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v2H4zM4 8h10v2H4z"/></svg>
              <h3>Manutenção & SEO Local</h3>
              <p>Atualizações, segurança e otimizações básicas para buscadores locais — ideal para clientes da sua região.</p>
              <small>Backups • Performance • SEO on-page</small>
            </article>
          </div>

          <div style="margin-top:18px;">
            <a class="btn-cta" href="#contact" title="Solicitar orçamento">Solicitar Orçamento</a>
          </div>
        </section>

        <section id="tech">
          <h2 class="section-title">Tecnologias</h2>
          <div class="tech-grid">
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/1216/1216733.png" alt="" srcset="">
                <rect x="3" y="4" width="18" height="14" rx="2" ry="2" />
              </svg>
              <p>HTML5</p>
              <small>Estrutura e semântica</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/5968/5968242.png" alt="" srcset="">
                <rect x="3" y="3" width="18" height="18" rx="3" ry="3" />
              </svg>
              <p>CSS3</p>
              <small>Design e responsividade</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/5968/5968292.png" alt="" srcset="">
                <path d="M4 4h16v16H4z" />
              </svg>
              <p>JavaScript</p>
              <small>Interatividade e lógica</small>
            </div>
            <div class="tech-card">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/React-icon.svg/1150px-React-icon.svg.png" alt="" srcset="">
                <path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z" />
              </svg>
              <p>React</p>
              <small>Bibliotecas e escalabilidade</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/5968/5968332.png" alt="" srcset="">
                <path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z" />
              </svg>
              <p>PHP</p>
              <small>Back-end e validações</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/226/226777.png" alt="" srcset="">
                <path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z" />
              </svg>
              <p>Java</p>
              <small>Aplicações multiplataforma</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/6132/6132221.png" alt="" srcset="">
                <path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z" />
              </svg>
              <p>C#</p>
              <small>Jogos e web</small>
            </div>
            <div class="tech-card">
              <img src="https://cdn-icons-png.flaticon.com/512/5815/5815478.png" alt="" srcset="">
                <path d="M12 2l3 7h7l-6 5 2 7-6-4-6 4 2-7-6-5h7z" />
              </svg>
              <p>SQL</p>
              <small>Banco de dados e consultas</small>
            </div>
          </div>
        </section>

        <section id="projects" aria-labelledby="projects-title">
          <h2 class="section-title" id="projects-title">Projetos</h2>

          <p style="color:var(--muted);max-width:900px">
            Alguns trabalhos (exemplos/estudos) que demonstram nossas capacidades: landing pages, sites institucionais
            e lojas simples. Podemos apresentar o código ou mockups para cada projeto mediante contato.
          </p>

          <div class="projects-grid">
            <article class="project-card">
              <div class="project-thumb" aria-hidden="true">
                <!-- placeholder SVG mockup -->
                <img src="../logo.png" alt="">
              </div>
              <div class="project-body">
                <h3>Tech-Pet</h3>
                <p class="muted">segurança e confiabilidade provida pela Tech-Pet para uma relação de confiança entre dono e o seu pet.</p>
                <small>HTML • CSS • JS • PHP</small>
              </div>
            </article>

            <article class="project-card">
              <div class="project-thumb" aria-hidden="true">
                <img src="../teste/img-t/t5.png" alt="">
              </div>
              <div class="project-body">
                <h3>The Cult</h3>
                <p class="muted">Viva a aventura de um guerreiro em masmorras cheias de inimigos e itens para coletar. A cada batalha, torne-se mais poderoso.</p>
                <small>Dungeon Crawler • Action RPG</small>
              </div>
            </article>

            <article class="project-card">
              <div class="project-thumb" aria-hidden="true">
                <img src="./img-t/organo-print.png" alt="">
              </div>
              <div class="project-body">
                <h3>Organo</h3>
                <p class="muted">Cadastre pessoas, enquanto organizar equipes isso facilita a distribuição de funções e melhora a colaboração.</p>
                <small>React • Cadastro • Design</small>
              </div>
            </article>
          </div>

          <div style="margin-top:18px;">
            <a class="btn-cta" href="#contact" title="Ver portfólio completo">Ver Portfólio / Contato</a>
          </div>
        </section>

        <section id="about">
          <h2 class="section-title">Sobre Nós</h2>
          <p style="color: var(--muted); max-width: 900px">
            Apresentamos a Dev16 — uma pequena empresa criada por três
            estudantes de tecnologia. Unimos design e programação para entregar
            sites profissionais, lojas online e interfaces modernas, sempre com
            foco em clareza e resultado.
          </p>

          <div class="team-row" aria-label="Equipe Dev16">

            <a href="./membro.php" class="a_dev">
              <div class="member">
                <div class="avatar" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-5 0-8 2.5-8 6v2h16v-2c0-3.5-3-6-8-6z"
                    />
                  </svg>
                </div>
                <h4>Dev Frontend</h4>
                <p>
                  Estudante de programação, apaixonado por interfaces e por
                  transformar design em experiência funcional.
                </p>
              </div>
            </a>

            <a href="./membro.php" class="a_dev">
              <div class="member">
                <div class="avatar" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-5 0-8 2.5-8 6v2h16v-2c0-3.5-3-6-8-6z"
                    />
                  </svg>
                </div>
                <h4>Dev Backend</h4>
                <p>
                  Focado em lógica, bancos de dados e integrações; garante que os
                  projetos funcionem de forma estável e segura.
                </p>
              </div>
            </a>

            <a href="./membro.php" class="a_dev" >
              <div class="member">
                <div class="avatar" aria-hidden="true">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-5 0-8 2.5-8 6v2h16v-2c0-3.5-3-6-8-6z"
                    />
                  </svg>
                </div>
                <h4>Designer UI/UX</h4>
                <p>
                  Responsável pelo visual, protótipos e usabilidade — garante que
                  a solução seja bonita, intuitiva e acessível.
                </p>
              </div>
            </a>
          </div>
        </section>

        <section id="contact" class="contact">
  <div class="wrap form-wrap">
    <h2 class="section-title">Enviar</h2>

    <!-- exemplo: substitua action/method pelos seus -->
    <form class="send-email" action="./enviar_email.php" method="post" novalidate>
      <div class="form-row">
        <input type="text" name="nome" placeholder="Nome" required />
        
        <input type="text" name="assunto" placeholder="Assunto" />
      </div>

      <textarea name="mensagem" placeholder="Mensagem" required></textarea>

      <div class="form-actions">
        <button class="send" type="submit">Enviar Mensagem</button>
      </div>
    </form>


<script>
(function(){
  // pega o form que envia para enviar_email.php (ou o primeiro form se não achar)
  const form = document.querySelector('form[action*="enviar_email.php"]') || document.querySelector('form');
  if (!form) return;

  async function sendAjax(event) {
    event.preventDefault();
    // feedback
    const btn = form.querySelector('button[type="submit"], input[type="submit"]');
    const orig = btn ? btn.innerHTML : null;
    if (btn) { btn.disabled = true; btn.innerText = 'Enviando...'; }

    try {
      const fd = new FormData(form);
      const res = await fetch(form.action || 'enviar_email.php', {
        method: 'POST',
        body: fd,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'text/html'
        }
      });
      const text = await res.text();

      // mostra resultado em um elemento #form-status (cria se não existir)
      let status = document.getElementById('form-status');
      if (!status) {
        status = document.createElement('div');
        status.id = 'form-status';
        status.style.marginTop = '12px';
        form.parentNode.insertBefore(status, form.nextSibling);
      }

      if (res.ok && text.includes('Mensagem enviada com sucesso')) {
        status.innerHTML = '<div style="padding:10px;border-radius:6px;background:#e6ffed;color:#0a7a3a;border:1px solid #9fe5b7;">Mensagem enviada com sucesso ✅</div>';
        form.reset();
      } else {
        // tenta extrair erro do HTML retornado
        let msg = 'Erro ao enviar a mensagem.';
        const h2 = text.match(/<h2[^>]*>([^<]+)<\/h2>/i);
        const li = text.match(/<li>(.*?)<\/li>/i);
        if (h2) msg = h2[1];
        else if (li) msg = li[1].replace(/<[^>]+>/g,'');
        else if (!res.ok) msg = 'Erro HTTP: ' + res.status;
        status.innerHTML = '<div style="padding:10px;border-radius:6px;background:#ffecec;color:#9b2b2b;border:1px solid #f1a3a3;">' + msg + '</div>';
      }
    } catch (err) {
      let status = document.getElementById('form-status');
      if (!status) {
        status = document.createElement('div');
        status.id = 'form-status';
        status.style.marginTop = '12px';
        form.parentNode.insertBefore(status, form.nextSibling);
      }
      status.innerHTML = '<div style="padding:10px;border-radius:6px;background:#ffecec;color:#9b2b2b;border:1px solid #f1a3a3;">Erro de rede: ' + (err.message || err) + '</div>';
    } finally {
      if (btn) { btn.disabled = false; btn.innerHTML = orig; }
    }
  }

  // intercepta envio normal
  form.addEventListener('submit', sendAjax, {capture:true});

  // evita navegação se algum outro script chamar form.submit()
  const originalSubmit = HTMLFormElement.prototype.submit;
  HTMLFormElement.prototype.submit = function() {
    const evt = new Event('submit', {cancelable:true});
    if (this.dispatchEvent(evt)) {
      // se não cancelado, usa nossa função AJAX
      sendAjax.call(this, evt);
    }
    // NÃO chama originalSubmit para evitar navegação
  };
})();
</script>


  </div>
</section>

      </main>

      <footer>
        © <span id="year"></span> Dev16 — Pequena empresa de desenvolvimento.
        Todos os direitos reservados.
      </footer>
    </div>
    <a
      class="whatsapp"
      href="https://wa.me/555195707416"
      target="_blank"
      aria-label="WhatsApp"
    >
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M20.52 3.48A11.87 11.87 0 0012 .5C5.7.5.99 5.21.99 11.5c0 2.03.54 4 1.57 5.73L.5 23.5l6.53-1.72A11.98 11.98 0 0012 23.5c6.3 0 11.01-4.71 11.01-11 0-1.9-.47-3.68-1.49-5.02zM12 20.5c-1.76 0-3.45-.45-4.95-1.3l-.35-.19-3.88 1.02 1.05-3.77-.23-.38A8.93 8.93 0 013 11.5c0-5 4.06-9.01 9-9.01 5 0 9.01 4.01 9.01 9 0 4.99-4.03 9-9.01 9z"
        />
      </svg>
    </a>


<script>
(function(){
  const form = document.querySelector('form[action*="enviar_email.php"]') || document.querySelector('form');
  if (!form) return;

  // cria container do alerta se não existir
  let alertBox = document.createElement('div');
  alertBox.id = "alert-box";
  alertBox.style.position = "fixed";
  alertBox.style.top = "20px";
  alertBox.style.right = "20px";
  alertBox.style.padding = "16px 24px";
  alertBox.style.borderRadius = "8px";
  alertBox.style.color = "#fff";
  alertBox.style.fontFamily = "Arial, sans-serif";
  alertBox.style.fontSize = "16px";
  alertBox.style.boxShadow = "0 4px 12px rgba(0,0,0,0.15)";
  alertBox.style.opacity = "0";
  alertBox.style.pointerEvents = "none";
  alertBox.style.transition = "all 0.4s ease";
  document.body.appendChild(alertBox);

  function showAlert(message, type="success") {
    alertBox.innerHTML = message;
    alertBox.style.background = type === "success" ? "#28a745" : "#dc3545"; // verde / vermelho
    alertBox.style.opacity = "1";
    alertBox.style.pointerEvents = "auto";
    alertBox.style.transform = "translateY(0)";
    setTimeout(() => {
      alertBox.style.opacity = "0";
      alertBox.style.pointerEvents = "none";
    }, 4000); // some depois de 4s
  }

  async function sendAjax(event) {
    event.preventDefault();

    const btn = form.querySelector('button[type="submit"], input[type="submit"]');
    const orig = btn ? btn.innerHTML : null;
    if (btn) { btn.disabled = true; btn.innerHTML = "Enviando..."; }

    try {
      const fd = new FormData(form);
      const res = await fetch(form.action, {
        method: 'POST',
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const text = await res.text();

      if (res.ok && text.includes("Mensagem enviada com sucesso")) {
        showAlert("✅ Mensagem enviada com sucesso!", "success");
        form.reset();
      } else {
        showAlert("❌ Erro ao enviar a mensagem!", "error");
      }
    } catch (err) {
      showAlert("⚠️ Erro de rede: " + err.message, "error");
    } finally {
      if (btn) { btn.disabled = false; btn.innerHTML = orig; }
    }
  }

  form.addEventListener("submit", sendAjax, {capture:true});
})();
</script>

  </body>
</html>
