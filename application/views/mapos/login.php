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
      padding: 24px;
    }

    .login-wrapper {
      width: 100%;
      max-width: 820px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 28px;
      align-items: center;
    }

    /* Coluna Esquerda: Imagem Pareada com Logo */
    .showcase-column {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
    }

    .brand-logo-wrap {
      margin-bottom: 14px;
      text-align: center;
    }

    .brand-logo-img {
      height: 38px;
      width: auto;
      max-width: 210px;
      object-fit: contain;
      filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
    }

    .hero-image-card {
      width: 100%;
      height: 350px;
      border-radius: 14px;
      overflow: hidden;
      border: 1px solid var(--card-border);
      box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.65);
      background: #111620;
    }

    .hero-image-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      display: block;
      transition: transform 0.4s ease;
    }

    .hero-image-card:hover img {
      transform: scale(1.02);
    }

    /* Coluna Direita: Card de Login */
    .auth-column {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }

    .auth-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 26px 24px;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.65);
    }

    .auth-card-title {
      font-size: 20px;
      font-weight: 800;
      color: var(--text-white);
      margin-bottom: 4px;
      letter-spacing: -0.3px;
    }

    .auth-card-subtitle {
      font-size: 12.5px;
      color: var(--text-muted);
      line-height: 1.45;
      margin-bottom: 18px;
    }

    .form-group-custom {
      margin-bottom: 14px;
    }

    .form-label-custom {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 6px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon-left {
      position: absolute;
      left: 13px;
      width: 16px;
      height: 16px;
      color: var(--text-dim);
      pointer-events: none;
    }

    .input-control {
      width: 100% !important;
      background: var(--input-bg) !important;
      border: 1px solid var(--input-border) !important;
      border-radius: 7px !important;
      padding: 10px 38px !important;
      font-size: 13px !important;
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
      right: 10px;
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
      width: 16px;
      height: 16px;
    }

    .form-options-row {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      margin: 12px 0 18px 0;
      font-size: 12px;
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
      width: 14px;
      height: 14px;
      cursor: pointer;
    }

    .btn-submit-gradient {
      width: 100%;
      background: var(--accent-gradient);
      color: #ffffff;
      border: none;
      border-radius: 7px;
      padding: 11px;
      font-size: 13.5px;
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

    .card-footer-bar {
      margin-top: 16px;
      padding-top: 12px;
      border-top: 1px solid #1e2636;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11px;
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
      margin-top: 16px;
      text-align: center;
      font-size: 11.5px;
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
    @media (max-width: 820px) {
      .login-wrapper {
        grid-template-columns: 1fr;
        max-width: 380px;
        gap: 20px;
      }
      .hero-image-card {
        height: 200px;
      }
      .auth-column {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="login-wrapper">
    <!-- Coluna Esquerda: Imagem Pareada com Logo -->
    <div class="showcase-column">
      <div class="brand-logo-wrap">
        <img src="<?= base_url() ?>assets/img/Logo-Claro2.png" class="brand-logo-img" alt="Amura Sistemas">
      </div>

      <div class="hero-image-card">
        <img src="<?= base_url() ?>assets/img/os-hero.jpg" alt="Amura OS">
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

          <!-- Manter conectado -->
          <div class="form-options-row">
            <label class="checkbox-label">
              <input type="checkbox" id="rememberMe" name="remember">
              <span>Manter conectado</span>
            </label>
          </div>

          <!-- Botão Submit -->
          <button type="submit" id="btn-acessar" class="btn-submit-gradient">
            <span id="btnText">Acessar o sistema</span>
          </button>

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
