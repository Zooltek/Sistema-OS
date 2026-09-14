<div id="content">
<!--start-top-serch-->
  <div id="content-header">
   <div></div>
      <div id="breadcrumb">
        <a href="<?= base_url() ?>" title="Início" class="tip-bottom"> Início</a>
        <?php if ($this->uri->segment(1) != null) { 
            $seg1 = $this->uri->segment(1);
            $seg1Map = [
                'mapos' => 'Amura OS',
                'amuraOS' => 'Amura OS',
                'sistema' => 'Sistema',
                'clientes' => 'Clientes',
                'produtos' => 'Produtos',
                'servicos' => 'Serviços',
                'os' => 'Ordens de Serviço',
                'vendas' => 'Vendas',
                'garantias' => 'Garantias',
                'arquivos' => 'Arquivos',
                'financeiro' => 'Financeiro',
                'cobrancas' => 'Cobranças',
                'relatorios' => 'Relatórios',
                'usuarios' => 'Usuários',
                'permissoes' => 'Permissões',
                'auditoria' => 'Auditoria',
            ];
            $seg1Name = $seg1Map[$seg1] ?? ucfirst($seg1);
        ?>
            <a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) ?>" class="tip-bottom" title="<?= $seg1Name; ?>">
              <?= $seg1Name; ?>
            </a>
          <?php if ($this->uri->segment(2) != null) { 
              $seg2 = $this->uri->segment(2);
              $seg2Map = [
                  'configurar' => 'Configurações',
                  'emitente' => 'Emitente',
                  'backup' => 'Backup',
                  'emails' => 'Emails',
                  'minhaConta' => 'Minha Conta',
                  'pesquisar' => 'Pesquisa',
                  'calendario' => 'Calendário',
                  'atualizarMapos' => 'Atualizar Sistema',
                  'atualizarSistema' => 'Atualizar Sistema',
                  'atualizarBanco' => 'Atualizar Banco',
                  'adicionar' => 'Adicionar',
                  'editar' => 'Editar',
                  'visualizar' => 'Visualizar',
                  'gerenciar' => 'Gerenciar',
                  'lancamentos' => 'Lançamentos',
              ];
              $seg2Name = $seg2Map[$seg2] ?? ucfirst($seg2);
          ?>
            <a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) ?>" class="current tip-bottom" title="<?= $seg2Name; ?>">
              <?= $seg2Name; ?>
            </a>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="container-flu">
      <div class="row-fluid">
        <div class="span12">
          <?php if ($var = $this->session->flashdata('success')): ?><script>swal("Sucesso!", "<?php echo str_replace('"', '', $var); ?>", "success");</script><?php endif; ?>
          <?php if ($var = $this->session->flashdata('error')): ?><script>swal("Falha!", "<?php echo str_replace('"', '', $var); ?>", "error");</script><?php endif; ?>
          <?php if (isset($view)) {
              echo $this->load->view($view, null, true);
          } ?>
        </div>
      </div>
    </div>
  </div>
