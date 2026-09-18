<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title><?= $this->config->item('app_name') ?> - Área do Cliente</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?= $this->config->item('app_name') ?> - Portal e Área do Cliente">
  <meta name="csrf-token-name" content="<?= config_item("csrf_token_name") ?>">
  <meta name="csrf-cookie-name" content="<?= config_item("csrf_cookie_name") ?>">
  
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" />
  <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/img/favicon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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
      max-width: 1060px;
      display: grid;
      grid-template-columns: 1.18fr 0.82fr;
      gap: 68px;
      align-items: center;
    }

    /* Coluna Esquerda: Logo, Imagem Hero e Frase de Impacto */
    .showcase-column {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      width: 100%;
    }

    .brand-logo-wrap {
      margin-bottom: 16px;
      align-self: flex-start;
    }

    .brand-logo-img {
      height: 40px;
      width: auto;
      max-width: 220px;
      object-fit: contain;
      filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
      display: block;
    }

    .hero-image-card {
      width: 100%;
      height: 395px;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--card-border);
      box-shadow: 0 22px 50px -12px rgba(0, 0, 0, 0.75);
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

    .hero-impact-text {
      margin-top: 16px;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--text-muted);
      text-align: left;
      line-height: 1.5;
      letter-spacing: -0.2px;
      max-width: 520px;
    }

    .accent-gradient {
      background: var(--accent-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 700;
    }

    /* Coluna Direita: Card de Autenticação */
    .auth-column {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
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

    .portal-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 10px;
      background: rgba(244, 98, 58, 0.12);
      border: 1px solid rgba(244, 98, 58, 0.3);
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
      color: #ff9204;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 12px;
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
      position: relative;
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
      margin-top: 6px;
      text-decoration: none;
    }

    .btn-submit-gradient:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 22px rgba(217, 32, 120, 0.45);
      color: #ffffff;
      text-decoration: none;
    }

    .btn-secondary-outline {
      width: 100%;
      background: rgba(255, 255, 255, 0.04);
      color: #e2e8f0;
      border: 1px solid #2e384d;
      border-radius: 7px;
      padding: 10px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
      text-decoration: none;
    }

    .btn-secondary-outline:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: #475569;
      color: #ffffff;
      text-decoration: none;
    }

    .card-footer-bar {
      margin-top: 18px;
      padding-top: 12px;
      border-top: 1px solid #1e2636;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11.5px;
      color: var(--text-dim);
    }

    .card-footer-bar a {
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.2s;
    }

    .card-footer-bar a:hover {
      color: #f4623a;
      text-decoration: underline;
    }

    .help-inline {
      display: block;
      color: #f87171 !important;
      font-size: 11px;
      margin-top: 4px;
      padding-left: 2px;
    }

    @media (max-width: 900px) {
      .login-wrapper {
        grid-template-columns: 1fr;
        gap: 36px;
      }

      .hero-image-card {
        height: 240px;
      }

      .auth-column {
        align-items: center;
      }

      .auth-card {
        max-width: 100%;
      }
    }
  </style>
</head>

<?php
$parse_email = $this->input->get('e');
$parse_cpfcnpj = $this->input->get('c');
?>

<body>
  <div class="login-wrapper">
    <!-- Coluna Esquerda: Logo, Imagem Hero e Frase de Impacto -->
    <div class="showcase-column">
      <div class="brand-logo-wrap">
        <img src="<?= base_url() ?>assets/img/Logo-Claro2.png" class="brand-logo-img" alt="Amura Sistemas">
      </div>

      <div class="hero-image-card">
        <img src="<?= base_url() ?>assets/img/client-portal-hero.jpg" alt="Área do Cliente Amura OS">
      </div>

      <p class="hero-impact-text">
        Acompanhe suas ordens de serviço, orçamentos e garantias com <span class="accent-gradient">transparência e agilidade</span>.
      </p>
    </div>

    <!-- Coluna Direita: Formulário de Autenticação -->
    <div class="auth-column">
      <div class="auth-card">
        <div class="portal-badge">
          <i class="bx bx-user-check"></i> Área do Cliente
        </div>
        <h2 class="auth-card-title">Acessar seu Painel</h2>
        <p class="auth-card-subtitle">Informe seu e-mail e senha para visualizar suas ordens de serviço e faturas.</p>

        <form id="formLogin" method="post" action="<?= site_url('mine/login') ?>">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

          <!-- E-mail -->
          <div class="form-group-custom">
            <label class="form-label-custom" for="email">E-mail ou Documento</label>
            <div class="input-wrapper">
              <svg class="input-icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              <input id="email" name="email" type="text" class="input-control" placeholder="seuemail@exemplo.com" value="<?= trim($parse_email); ?>" required autofocus autocomplete="username">
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

          <!-- Botão de Acesso Principal -->
          <button type="submit" class="btn-submit-gradient" id="btnAcessar">
            <span>Entrar no Portal</span>
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </button>

          <!-- Botão de Cadastro -->
          <a href="<?= site_url('mine/cadastrar') ?>" class="btn-secondary-outline">
            <i class="bx bx-user-plus"></i>
            <span>Primeiro acesso? Cadastre-se</span>
          </a>

          <!-- Rodapé do Card -->
          <div class="card-footer-bar">
            <a href="<?= site_url('mine/resetarSenha') ?>">Esqueceu sua senha?</a>
            <span><?= date('Y'); ?> &copy; <?= $this->config->item('app_name') ?></span>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
  <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>

  <?php if ($this->session->flashdata('success') != null) { ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: '<?= addslashes($this->session->flashdata('success')); ?>',
        showConfirmButton: false,
        timer: 4000
      });
    </script>
  <?php } ?>

  <?php if ($this->session->flashdata('error') != null) { ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: '<?= addslashes($this->session->flashdata('error')); ?>',
        showConfirmButton: false,
        timer: 4000
      });
    </script>
  <?php } ?>

  <script type="text/javascript">
    $(document).ready(function() {
      // Toggle de visualização da senha
      $('#btnTogglePassword').on('click', function(e) {
        e.preventDefault();
        var passwordInput = $('#senha');
        var isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');
        
        var eyeSvg = isPassword
          ? '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>'
          : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        $('#eyeIcon').html(eyeSvg);
      });

      // Validação e envio AJAX
      $("#formLogin").validate({
        rules: {
          email: {
            required: true
          },
          senha: {
            required: true
          }
        },
        messages: {
          email: {
            required: 'Informe seu e-mail ou documento.'
          },
          senha: {
            required: 'Informe sua senha de acesso.'
          }
        },
        submitHandler: function(form) {
          var btn = $('#btnAcessar');
          btn.prop('disabled', true).css('opacity', '0.7');
          var dados = $(form).serialize();

          $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>index.php/mine/login?ajax=true",
            data: dados,
            dataType: 'json',
            success: function(data) {
              if (data.result == true) {
                window.location.href = "<?= base_url(); ?>index.php/mine/painel";
              } else {
                btn.prop('disabled', false).css('opacity', '1');
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Os dados de acesso estão incorretos.\nPor favor tente novamente!',
                  showConfirmButton: false,
                  timer: 4000
                });

                if (data.MAPOS_TOKEN) {
                  $("input[name='<?= $this->security->get_csrf_token_name(); ?>']").val(data.MAPOS_TOKEN);
                }
              }
            },
            error: function() {
              btn.prop('disabled', false).css('opacity', '1');
            }
          });

          return false;
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element) {
          $(element).css('border-color', '#ef4444');
        },
        unhighlight: function(element) {
          $(element).css('border-color', 'var(--input-border)');
        }
      });
    });
  </script>
</body>

</html>
