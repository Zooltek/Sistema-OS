<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title><?= $this->config->item('app_name') ?> - Login Corporativo</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" />
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --bg-dark: #090c10;
      --bg-radial: radial-gradient(circle at 40% 30%, #151b27 0%, #090c10 85%);
      --card-bg: #141923;
      --card-border: #212938;
      --input-bg: #19202c;
      --input-border: #293448;
      --accent-gradient: linear-gradient(90deg, #d92078 0%, #f4623a 100%);
      --text-white: #ffffff;
      --text-light: #f1f5f9;
      --text-muted: #94a3b8;
      --text-dim: #64748b;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background: var(--bg-dark);
      background-image: var(--bg-radial);
      background-attachment: fixed;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: var(--text-light);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }

    .login-wrapper {
      width: 100%;
      max-width: 1240px;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 64px;
      align-items: center;
    }

    /* Coluna Esquerda: Showcase */
    .showcase-column {
      display: flex;
      flex-direction: column;
    }

    .brand-logo-wrap {
      margin-bottom: 24px;
    }

    .brand-logo-img {
      height: 42px;
      width: auto;
      object-fit: contain;
      filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
    }

    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.12);
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.8px;
      color: var(--text-muted);
      text-transform: uppercase;
      width: fit-content;
      margin-bottom: 18px;
    }

    .badge-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #f97316;
      box-shadow: 0 0 8px #f97316;
    }

    .hero-title {
      font-size: 38px;
      font-weight: 800;
      line-height: 1.2;
      color: var(--text-white);
      letter-spacing: -0.8px;
      margin-bottom: 16px;
    }

    .accent-gradient {
      background: var(--accent-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
    }

    .hero-subtitle {
      font-size: 14.5px;
      line-height: 1.65;
      color: var(--text-muted);
      max-width: 540px;
      margin-bottom: 26px;
    }

    .hero-image-card {
      width: 100%;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--card-border);
      box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.6);
      margin-bottom: 24px;
      background: #111620;
    }

    .hero-image-card img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .hero-image-card:hover img {
      transform: scale(1.015);
    }

    /* 3 Features Inferiores */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }

    .feature-item {
      background: #121722;
      border: 1px solid #1c2433;
      border-radius: 12px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      transition: border-color 0.2s, transform 0.2s;
    }

    .feature-item:hover {
      border-color: #2b364c;
      transform: translateY(-2px);
    }

    .feature-icon {
      width: 20px;
      height: 20px;
      color: #f97316;
      margin-bottom: 4px;
    }

    .feature-title {
      font-size: 13px;
      font-weight: 700;
      color: var(--text-light);
    }

    .feature-desc {
      font-size: 11.5px;
      line-height: 1.45;
      color: var(--text-dim);
    }

    /* Coluna Direita: Card de Login */
    .auth-column {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .auth-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 18px;
      padding: 40px 34px;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);
    }

    .auth-card-title {
      font-size: 22px;
      font-weight: 800;
      color: var(--text-white);
      margin-bottom: 6px;
      letter-spacing: -0.3px;
    }

    .auth-card-subtitle {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 26px;
    }

    .form-group-custom {
      margin-bottom: 18px;
    }

    .form-label-custom {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 7px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon-left {
      position: absolute;
      left: 14px;
      width: 17px;
      height: 17px;
      color: var(--text-dim);
      pointer-events: none;
    }

    .input-control {
      width: 100% !important;
      background: var(--input-bg) !important;
      border: 1px solid var(--input-border) !important;
      border-radius: 8px !important;
      padding: 12px 42px 12px 42px !important;
      font-size: 13.5px !important;
      color: #ffffff !important;
      outline: none !important;
      height: auto !important;
      box-shadow: none !important;
      transition: all 0.2s ease !important;
    }

    .input-control:focus {
      border-color: #f4623a !important;
      box-shadow: 0 0 0 3px rgba(244, 98, 58, 0.15) !important;
    }

    .btn-toggle-eye {
      position: absolute;
      right: 12px;
      background: transparent;
      border: none;
      color: var(--text-dim);
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      outline: none;
      transition: color 0.2s;
    }

    .btn-toggle-eye:hover {
      color: var(--text-light);
    }

    .btn-toggle-eye svg {
      width: 17px;
      height: 17px;
    }

    .form-options-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 18px 0 24px 0;
      font-size: 12.5px;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--text-muted);
      cursor: pointer;
      user-select: none;
    }

    .checkbox-label input[type="checkbox"] {
      margin: 0;
      accent-color: #f4623a;
      width: 15px;
      height: 15px;
      cursor: pointer;
    }

    .forgot-link {
      color: #f4623a;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s;
    }

    .forgot-link:hover {
      color: #ff7b57;
      text-decoration: underline;
    }

    .btn-submit-gradient {
      width: 100%;
      background: var(--accent-gradient);
      color: #ffffff;
      border: none;
      border-radius: 8px;
      padding: 13px;
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.2px;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(217, 32, 120, 0.35);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-submit-gradient:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 22px rgba(217, 32, 120, 0.45);
      color: #ffffff;
    }

    .btn-submit-gradient.disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }

    .security-notice {
      margin-top: 22px;
      background: #171f2b;
      border: 1px solid #232d3d;
      border-radius: 8px;
      padding: 12px 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 11.5px;
      color: var(--text-muted);
      line-height: 1.45;
    }

    .security-notice svg {
      width: 18px;
      height: 18px;
      color: #10b981;
      flex-shrink: 0;
    }

    .card-footer-bar {
      margin-top: 22px;
      padding-top: 14px;
      border-top: 1px solid #1e2636;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11.5px;
      color: var(--text-dim);
    }

    .card-footer-bar a {
      color: var(--text-dim);
      text-decoration: none;
      transition: color 0.2s;
    }

    .card-footer-bar a:hover {
      color: var(--text-muted);
    }

    .outer-footer {
      margin-top: 24px;
      text-align: center;
      font-size: 12px;
      color: #475569;
    }

    /* Modal Escuro Customizado */
    .modal-dark {
      background: #141923 !important;
      border: 1px solid #273142 !important;
      border-radius: 12px !important;
      color: #f1f5f9 !important;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8) !important;
    }

    .modal-dark .modal-header {
      border-bottom: 1px solid #273142 !important;
      padding: 16px 24px !important;
    }

    .modal-dark .modal-header h4 {
      color: #f97316 !important;
      font-size: 16px !important;
      font-weight: 700 !important;
    }

    .modal-dark .modal-body {
      padding: 24px !important;
      font-size: 14px !important;
      color: #cbd5e1 !important;
      line-height: 1.6 !important;
    }

    .modal-dark .modal-footer {
      background: #0f131a !important;
      border-top: 1px solid #273142 !important;
      padding: 12px 24px !important;
    }

    .modal-dark .btn-close-modal {
      background: #232d3d !important;
      color: #fff !important;
      border: 1px solid #334155 !important;
      padding: 8px 20px !important;
      border-radius: 6px !important;
      cursor: pointer !important;
    }

    .modal-dark .btn-close-modal:hover {
      background: #334155 !important;
    }

    /* Responsividade */
    @media (max-width: 980px) {
      .login-wrapper {
        grid-template-columns: 1fr;
        gap: 40px;
      }
      .showcase-column {
        align-items: center;
        text-align: center;
      }
      .badge-pill {
        margin: 0 auto 16px auto;
      }
      .hero-title {
        font-size: 30px;
      }
      .hero-subtitle {
        margin: 0 auto 24px auto;
      }
      .auth-column {
        width: 100%;
      }
    }

    @media (max-width: 600px) {
      .features-grid {
        grid-template-columns: 1fr;
      }
      .auth-card {
        padding: 28px 20px;
      }
      .hero-title {
        font-size: 26px;
      }
    }
  </style>
</head>

<body>
  <div class="login-wrapper">
    <!-- Coluna Esquerda: Showcase -->
    <div class="showcase-column">
      <div class="brand-logo-wrap">
        <img src="<?= base_url() ?>assets/img/Logo-Claro2.png" class="brand-logo-img" alt="Amura Sistemas">
      </div>

      <div class="badge-pill">
        <span class="badge-dot"></span> SISTEMA DE ORDENS DE SERVIÇO
      </div>

      <h1 class="hero-title">
        Cada chamado no lugar certo,<br>
        <span class="accent-gradient">do orçamento à assinatura</span>
      </h1>

      <p class="hero-subtitle">
        Controle completo das ordens de serviço da sua operação: abertura, agendamento, execução em campo e faturamento, com a inteligência da Amura Sistemas.
      </p>

      <div class="hero-image-card">
        <img src="<?= base_url() ?>assets/img/os-hero.jpg" alt="Amura OS Field Service">
      </div>

      <div class="features-grid">
        <div class="feature-item">
          <!-- Ícone Prancheta / Lista -->
          <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
          </svg>
          <div class="feature-title">Ordens em tempo real</div>
          <div class="feature-desc">Abertura, execução e conclusão em um fluxo só.</div>
        </div>

        <div class="feature-item">
          <!-- Ícone Cronômetro -->
          <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <circle cx="12" cy="12" r="9"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
          <div class="feature-title">SLA sob controle</div>
          <div class="feature-desc">Prazos, prioridades e alertas de atraso automáticos.</div>
        </div>

        <div class="feature-item">
          <!-- Ícone Ferramenta / Equipe -->
          <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"></path>
          </svg>
          <div class="feature-title">Equipe em campo</div>
          <div class="feature-desc">Técnicos, checklists e assinatura digital do cliente.</div>
        </div>
      </div>
    </div>

    <!-- Coluna Direita: Formulário de Autenticação -->
    <div class="auth-column">
      <div class="auth-card">
        <h2 class="auth-card-title">Acessar sua conta</h2>
        <p class="auth-card-subtitle">Use suas credenciais corporativas para entrar no Amura OS.</p>

        <?php if ($this->session->flashdata('error') != null) { ?>
          <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
            <?= $this->session->flashdata('error'); ?>
          </div>
        <?php } ?>

        <form id="formLogin" method="post" action="<?= site_url('login/verificarLogin') ?>">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <!-- E-mail -->
          <div class="form-group-custom">
            <label class="form-label-custom" for="email">E-mail</label>
            <div class="input-wrapper">
              <svg class="input-icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              <input id="email" name="email" type="email" class="input-control" placeholder="nome@suaempresa.com.br" required autofocus autocomplete="username">
            </div>
          </div>

          <!-- Senha -->
          <div class="form-group-custom">
            <label class="form-label-custom" for="senha">Senha</label>
            <div class="input-wrapper">
              <svg class="input-icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0110 0v4"></path>
              </svg>
              <input id="senha" name="senha" type="password" class="input-control" placeholder="••••••••" required autocomplete="current-password">
              <button type="button" class="btn-toggle-eye" id="btnTogglePassword" title="Mostrar/Ocultar Senha" tabindex="-1">
                <svg id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </button>
            </div>
          </div>

          <!-- Lembrar & Esqueci -->
          <div class="form-options-row">
            <label class="checkbox-label">
              <input type="checkbox" id="rememberMe" name="remember">
              <span>Manter conectado</span>
            </label>
            <a href="#modalForgot" data-toggle="modal" class="forgot-link">Esqueci minha senha</a>
          </div>

          <!-- Botão Submit -->
          <button type="submit" id="btn-acessar" class="btn-submit-gradient">
            <span id="btnText">Acessar o sistema</span>
          </button>

          <!-- Aviso de Segurança -->
          <div class="security-notice">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span>Ambiente protegido. Seus dados de ordens de serviço trafegam criptografados.</span>
          </div>

          <!-- Rodapé do Card -->
          <div class="card-footer-bar">
            <span>Versão: <?= $this->config->item('app_version') ?: '1.0.1'; ?></span>
            <a href="https://amura.com.br" target="_blank" rel="noopener">amura.com.br</a>
          </div>
        </form>
      </div>

      <div class="outer-footer">
        &copy; <?= date('Y'); ?> Amura Sistemas &middot; Suporte técnico disponível em dias úteis
      </div>
    </div>
  </div>

  <!-- Modal Notificação / Erro -->
  <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none;">notification</a>
  <div id="notification" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-labelledby="notificationLabel" aria-hidden="true">
    <div class="modal-header">
      <h4 id="notificationLabel">Amura OS</h4>
    </div>
    <div class="modal-body">
      <p id="message" style="text-align: center;">Os dados de acesso estão incorretos, por favor tente novamente!</p>
    </div>
    <div class="modal-footer">
      <button class="btn-close-modal" data-dismiss="modal" aria-hidden="true">Entendido</button>
    </div>
  </div>

  <!-- Modal Esqueci Minha Senha -->
  <div id="modalForgot" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-labelledby="forgotLabel" aria-hidden="true">
    <div class="modal-header">
      <h4 id="forgotLabel">Recuperação de Acesso</h4>
    </div>
    <div class="modal-body">
      <p>Para redefinir sua senha de acesso, solicite o reset diretamente ao <b>Administrador do Sistema</b> da sua empresa ou contate o suporte técnico oficial através de <b>suporte@amura.com.br</b>.</p>
    </div>
    <div class="modal-footer">
      <button class="btn-close-modal" data-dismiss="modal" aria-hidden="true">Fechar</button>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/validate.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      // Toggle de visibilidade da senha
      $('#btnTogglePassword').on('click', function() {
        const passwordInput = $('#senha');
        const eyeIcon = $('#eyeIcon');
        const isPassword = passwordInput.attr('type') === 'password';

        if (isPassword) {
          passwordInput.attr('type', 'text');
          eyeIcon.html(`
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
          `);
        } else {
          passwordInput.attr('type', 'password');
          eyeIcon.html(`
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          `);
        }
      });

      // Validação e Submit via AJAX
      $("#formLogin").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          senha: {
            required: true
          }
        },
        messages: {
          email: {
            required: 'Informe seu e-mail corporativo',
            email: 'Insira um e-mail válido'
          },
          senha: {
            required: 'Informe sua senha'
          }
        },
        submitHandler: function(form) {
          var dados = $(form).serialize();
          var btn = $('#btn-acessar');
          btn.addClass('disabled').prop('disabled', true);
          $('#btnText').text('Autenticando...');

          $.ajax({
            type: "POST",
            url: "<?= site_url('login/verificarLogin?ajax=true'); ?>",
            data: dados,
            dataType: 'json',
            success: function(data) {
              if (data.result == true) {
                $('#btnText').text('Conectado! Entrando...');
                window.location.href = "<?= site_url('mapos'); ?>";
              } else {
                btn.removeClass('disabled').prop('disabled', false);
                $('#btnText').text('Acessar o sistema');
                $('#message').text(data.message || 'Os dados de acesso estão incorretos, por favor tente novamente!');
                $('#call-modal').trigger('click');

                // Atualiza o token CSRF a cada requisição
                if (data.MAPOS_TOKEN) {
                  $("input[name='<?= $this->security->get_csrf_token_name(); ?>']").val(data.MAPOS_TOKEN);
                }
              }
            },
            error: function() {
              btn.removeClass('disabled').prop('disabled', false);
              $('#btnText').text('Acessar o sistema');
              $('#message').text('Ocorreu uma falha de comunicação com o servidor local. Tente novamente.');
              $('#call-modal').trigger('click');
            }
          });

          return false;
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element) {
          $(element).addClass('error');
        },
        unhighlight: function(element) {
          $(element).removeClass('error');
        }
      });
    });
  </script>
</body>
</html>
