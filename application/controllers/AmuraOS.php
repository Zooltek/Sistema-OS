<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class AmuraOS extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mapos_model');
    }

    public function index()
    {
        $status = ['Em Andamento', 'Aguardando Peças'];
        $this->data['ordens_status'] = $this->mapos_model->getOsStatus($status);
        $vstatus = ['Aberto', 'Em Andamento', 'Aguardando Peças', 'Aprovado', 'Orçamento'];
        $this->data['vendasstatus'] = $this->mapos_model->getVendasStatus($vstatus);
        $this->data['lancamentos'] = $this->mapos_model->getLancamentos();
        $this->data['ordens_orcamentos'] = $this->mapos_model->getOsOrcamentos();
        $this->data['ordens_abertas'] = $this->mapos_model->getOsAbertas();
        $this->data['ordens_aprovadas'] = $this->mapos_model->getOsAprovadas();
        $this->data['ordens_finalizadas'] = $this->mapos_model->getOsFinalizadas();
        $this->data['ordens_aguardando'] = $this->mapos_model->getOsAguardandoPecas();
        $this->data['ordens_andamento'] = $this->mapos_model->getOsAndamento();
        $this->data['produtos'] = $this->mapos_model->getProdutosMinimo();
        $this->data['os'] = $this->mapos_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro'] = $this->mapos_model->getEstatisticasFinanceiro();
        $this->data['financeiro_mes_dia'] = $this->mapos_model->getEstatisticasFinanceiroDia($this->input->get('year'));
        $this->data['financeiro_mes'] = $this->mapos_model->getEstatisticasFinanceiroMes($this->input->get('year'));
        $this->data['financeiro_mesinadipl'] = $this->mapos_model->getEstatisticasFinanceiroMesInadimplencia($this->input->get('year'));
        $this->data['menuPainel'] = 'Painel';
        $this->data['view'] = 'mapos/painel';

        return $this->layout();
    }

    public function minhaConta()
    {
        $this->data['usuario'] = $this->mapos_model->getById($this->session->userdata('id_admin'));
        $this->data['view'] = 'mapos/minhaConta';

        return $this->layout();
    }

    public function alterarSenha()
    {
        $current_user = $this->mapos_model->getById($this->session->userdata('id_admin'));

        if (!$current_user) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao pesquisar usuário!');
            redirect(site_url('mapos/minhaConta'));
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');

        if (!password_verify($oldSenha, $current_user->senha)) {
            $this->session->set_flashdata('error', 'A senha atual não corresponde com a senha informada.');
            redirect(site_url('mapos/minhaConta'));
        }

        $result = $this->mapos_model->alterarSenha($senha);

        if ($result) {
            $this->session->set_flashdata('success', 'Senha alterada com sucesso!');
            redirect(site_url('mapos/minhaConta'));
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a senha!');
        redirect(site_url('mapos/minhaConta'));
    }

    public function pesquisar()
    {
        $termo = $this->input->get('termo');

        $data['results'] = $this->mapos_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['view'] = 'mapos/pesquisa';

        return $this->layout();
    }

    public function backup()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para efetuar backup.');
            redirect(base_url());
        }

        $this->load->dbutil();
        $prefs = [
            'format' => 'zip',
            'foreign_key_checks' => false,
            'filename' => 'backup' . date('d-m-Y') . '.sql',
        ];

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url() . 'backup/backup.zip', $backup);

        log_info('Efetuou backup do banco de dados.');

        $this->load->helper('download');
        force_download('backup' . date('d-m-Y H:m:s') . '.zip', $backup);
    }

    public function restaurarBackup()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para restaurar backup.');
            redirect(base_url());
        }

        if (empty($_FILES['backup_file']['name'])) {
            $this->session->set_flashdata('error', 'Nenhum arquivo de backup (.sql ou .zip) foi enviado.');
            return redirect(site_url('sistema/configurar'));
        }

        $config['upload_path'] = './assets/';
        $config['allowed_types'] = 'sql|zip';
        $config['max_size'] = 51200; // 50MB max
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('backup_file')) {
            $this->session->set_flashdata('error', 'Falha no upload: ' . $this->upload->display_errors('', ''));
            return redirect(site_url('sistema/configurar'));
        }

        $uploadData = $this->upload->data();
        $filePath = $uploadData['full_path'];
        $extension = strtolower($uploadData['file_ext']);

        $sqlContent = '';
        if ($extension === '.zip') {
            $zip = new ZipArchive();
            if ($zip->open($filePath) === true) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entryName = $zip->getNameIndex($i);
                    if (pathinfo($entryName, PATHINFO_EXTENSION) === 'sql') {
                        $sqlContent = $zip->getFromIndex($i);
                        break;
                    }
                }
                $zip->close();
            }
        } else {
            $sqlContent = file_get_contents($filePath);
        }

        @unlink($filePath);

        if (empty($sqlContent)) {
            $this->session->set_flashdata('error', 'O arquivo enviado não contém instruções SQL válidas para restauração.');
            return redirect(site_url('sistema/configurar'));
        }

        try {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
            $lines = explode(";\n", $sqlContent);
            foreach ($lines as $line) {
                $statement = trim($line);
                if (!empty($statement)) {
                    $this->db->query($statement);
                }
            }
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

            log_info('Efetuou restauração do banco de dados via interface Web.');
            $this->session->set_flashdata('success', 'Banco de dados restaurado com sucesso!');
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Erro ao executar comandos de restauração: ' . $e->getMessage());
        }

        return redirect(site_url('sistema/configurar'));
    }

    public function aplicarPacoteAtualizacao()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para atualizar o sistema.');
            redirect(base_url());
        }

        if (empty($_FILES['package_file']['name'])) {
            $this->session->set_flashdata('error', 'Nenhum pacote de atualização (.zip) foi enviado.');
            return redirect(site_url('sistema/configurar'));
        }

        $config['upload_path'] = './assets/';
        $config['allowed_types'] = 'zip';
        $config['max_size'] = 102400; // 100MB
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('package_file')) {
            $this->session->set_flashdata('error', 'Falha no upload do pacote: ' . $this->upload->display_errors('', ''));
            return redirect(site_url('sistema/configurar'));
        }

        $uploadData = $this->upload->data();
        $zipPath = $uploadData['full_path'];
        $rootPath = FCPATH;

        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($rootPath);
            $zip->close();
            @unlink($zipPath);

            // Rodar migrações do banco se houver
            $this->load->library('migration');
            $this->migration->latest();

            log_info('Aplicou pacote de atualização do sistema via Web.');
            $this->session->set_flashdata('success', 'Pacote de atualização instalado com sucesso e migrações aplicadas!');
        } else {
            @unlink($zipPath);
            $this->session->set_flashdata('error', 'Não foi possível descompactar o arquivo de atualização.');
        }

        return redirect(site_url('sistema/configurar'));
    }

    public function emitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->data['menuConfiguracoes'] = 'Configuracoes';
        $this->data['dados'] = $this->mapos_model->getEmitente();
        $this->data['view'] = 'mapos/emitente';

        return $this->layout();
    }

    // Auxiliar interno: como método público seria acessível via /mapos/do_upload.
    protected function do_upload()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = [
            // SVG fora da lista: é um documento XML que pode carregar script e
            // seria servido a partir da própria origem da aplicação.
            'upload_path' => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size' => 2048,
            'remove_space' => true,
            'encrypt_name' => true,
        ];

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $file_info = [$this->upload->data()];

            return $file_info[0]['file_name'];
        }
    }

    // Auxiliar interno: como método público seria acessível via /mapos/do_upload_user.
    protected function do_upload_user()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/userImage/';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = [
            'upload_path' => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size' => 2048,
            'remove_space' => true,
            'encrypt_name' => true,
        ];

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $file_info = [$this->upload->data()];

            return $file_info[0]['file_name'];
        }
    }

    public function cadastrarEmitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required|trim');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required|trim');
        $this->form_validation->set_rules('ie', 'IE', 'trim');
        $this->form_validation->set_rules('cep', 'CEP', 'required|trim');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required|trim');
        $this->form_validation->set_rules('numero', 'Número', 'required|trim');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required|trim');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required|trim');
        $this->form_validation->set_rules('uf', 'UF', 'required|trim');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(site_url('mapos/emitente'));
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $cep = $this->input->post('cep');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $image = $this->do_upload();
            $logo = base_url() . 'assets/uploads/' . $image;

            $retorno = $this->mapos_model->addEmitente($nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email, $logo);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram inseridas com sucesso.');
                log_info('Adicionou informações de emitente.');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar inserir as informações.');
            }
            redirect(site_url('mapos/emitente'));
        }
    }

    public function editarEmitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required|trim');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required|trim');
        $this->form_validation->set_rules('ie', 'IE', 'trim');
        $this->form_validation->set_rules('cep', 'CEP', 'required|trim');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required|trim');
        $this->form_validation->set_rules('numero', 'Número', 'required|trim');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required|trim');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required|trim');
        $this->form_validation->set_rules('uf', 'UF', 'required|trim');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(site_url('mapos/emitente'));
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $cep = $this->input->post('cep');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $id = $this->input->post('id');

            $retorno = $this->mapos_model->editEmitente($id, $nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
                log_info('Alterou informações de emitente.');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
            }
            redirect(site_url('mapos/emitente'));
        }
    }

    public function editarLogo()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a logomarca.');
            redirect(site_url('mapos/emitente'));
        }
        $this->load->helper('file');
        delete_files(FCPATH . 'assets/uploads/');

        $image = $this->do_upload();
        $logo = base_url() . 'assets/uploads/' . $image;

        $retorno = $this->mapos_model->editLogo($id, $logo);
        if ($retorno) {
            $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
            log_info('Alterou a logomarca do emitente.');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
        }
        redirect(site_url('mapos/emitente'));
    }

    public function uploadUserImage()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para mudar a foto.');
            redirect(base_url());
        }

        $id = $this->session->userdata('id_admin');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar sua foto.');
            redirect(site_url('mapos/minhaConta'));
        }

        $usuario = $this->mapos_model->getById($id);

        if (is_file(FCPATH . 'assets/userImage/' . $usuario->url_image_user)) {
            unlink(FCPATH . 'assets/userImage/' . $usuario->url_image_user);
        }

        $image = $this->do_upload_user();
        $imageUserPath = $image;
        $retorno = $this->mapos_model->editImageUser($id, $imageUserPath);

        if ($retorno) {
            $this->session->set_userdata('url_image_user', $imageUserPath);
            $this->session->set_flashdata('success', 'Foto alterada com sucesso.');
            log_info('Alterou a Imagem do Usuario.');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar sua foto.');
        }
        redirect(site_url('mapos/minhaConta'));
    }

    public function emails()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmail')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar fila de e-mails');
            redirect(base_url());
        }

        $this->data['menuConfiguracoes'] = 'Email';

        $this->load->library('pagination');
        $this->load->model('email_model');

        $this->data['configuration']['base_url'] = site_url('mapos/emails/');
        $this->data['configuration']['total_rows'] = $this->email_model->count('email_queue');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->email_model->get('email_queue', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'emails/emails';

        return $this->layout();
    }

    public function excluirEmail()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmail')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir e-mail da fila.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir e-mail da fila.');
            redirect(site_url('mapos/emails/'));
        }

        $this->load->model('email_model');
        $this->email_model->delete('email_queue', 'id', $id);

        log_info('Removeu um e-mail da fila de envio. ID: ' . $id);

        $this->session->set_flashdata('success', 'E-mail removido da fila de envio!');
        redirect(site_url('mapos/emails/'));
    }

    public function configurar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }
        $this->data['menuConfiguracoes'] = 'Sistema';

        $this->load->library('form_validation');
        $this->load->model('mapos_model');

        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('app_name', 'Nome do Sistema', 'required|trim');
        $this->form_validation->set_rules('per_page', 'Registros por página', 'required|numeric|trim');
        $this->form_validation->set_rules('app_theme', 'Tema do Sistema', 'required|trim');
        $this->form_validation->set_rules('os_notification', 'Notificação de OS', 'required|trim');
        $this->form_validation->set_rules('email_automatico', 'Enviar Email Automático', 'required|trim');
        $this->form_validation->set_rules('control_estoque', 'Controle de Estoque', 'required|trim');
        $this->form_validation->set_rules('notifica_whats', 'Notificação Whatsapp', 'required|trim');
        $this->form_validation->set_rules('control_baixa', 'Controle de Baixa', 'required|trim');
        $this->form_validation->set_rules('control_editos', 'Controle de Edição de OS', 'required|trim');
        $this->form_validation->set_rules('control_edit_vendas', 'Controle de Edição de Vendas', 'required|trim');
        $this->form_validation->set_rules('control_datatable', 'Controle de Visualização em DataTables', 'required|trim');
        $this->form_validation->set_rules('os_status_list[]', 'Controle de visualização de OS', 'required|trim', ['required' => 'Selecione ao menos uma das opções!']);
        $this->form_validation->set_rules('control_2vias', 'Controle Impressão 2 Vias', 'required|trim');
        $this->form_validation->set_rules('pix_key', 'Chave Pix', 'trim|valid_pix_key', [
            'valid_pix_key' => 'Chave Pix inválida!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="alert">' . validation_errors() . '</div>' : false);
        } else {
            // Edição do .env
            $dataDotEnv = [
                'IMPRIMIR_ANEXOS' => $this->input->post('imprmirAnexos'),
                'PAYMENT_GATEWAYS_EFI_PRODUCTION' => $this->input->post('PAYMENT_GATEWAYS_EFI_PRODUCTION'),
                'PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID' => $this->input->post('PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID'),
                'PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET' => $this->input->post('PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET'),
                'PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION'),
                'PAYMENT_GATEWAYS_ASAAS_PRODUCTION' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_PRODUCTION'),
                'PAYMENT_GATEWAYS_ASAAS_NOTIFY' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_NOTIFY'),
                'PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY'),
                'PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION'),
                'API_ENABLED' => $this->input->post('apiEnabled'),
                'API_TOKEN_EXPIRE_TIME' => $this->input->post('apiExpireTime'),
                'API_JWT_KEY' => $this->input->post('resetJwtToken'),
                'EMAIL_PROTOCOL' => $this->input->post('EMAIL_PROTOCOL'),
                'EMAIL_SMTP_HOST' => $this->input->post('EMAIL_SMTP_HOST'),
                'EMAIL_SMTP_CRYPTO' => $this->input->post('EMAIL_SMTP_CRYPTO'),
                'EMAIL_SMTP_PORT' => $this->input->post('EMAIL_SMTP_PORT'),
                'EMAIL_SMTP_USER' => $this->input->post('EMAIL_SMTP_USER'),
                'EMAIL_SMTP_PASS' => $this->input->post('EMAIL_SMTP_PASS'),
            ];

            if (!$this->editDontEnv($dataDotEnv)) {
                $this->data['custom_error'] = '<div class="alert">Falha ao editar o .env</div>';
            }
            // FIM Edição do .env

            $data = [
                'app_name' => $this->input->post('app_name'),
                'per_page' => $this->input->post('per_page'),
                'app_theme' => $this->input->post('app_theme'),
                'os_notification' => $this->input->post('os_notification'),
                'email_automatico' => $this->input->post('email_automatico'),
                'control_estoque' => $this->input->post('control_estoque'),
                'notifica_whats' => $this->input->post('notifica_whats'),
                'control_baixa' => $this->input->post('control_baixa'),
                'control_editos' => $this->input->post('control_editos'),
                'control_edit_vendas' => $this->input->post('control_edit_vendas'),
                'control_datatable' => $this->input->post('control_datatable'),
                'pix_key' => $this->input->post('pix_key'),
                'os_status_list' => json_encode($this->input->post('os_status_list')),
                'control_2vias' => $this->input->post('control_2vias'),
            ];
            if ($this->mapos_model->saveConfiguracao($data) == true) {
                $this->session->set_flashdata('success', 'Configurações do sistema atualizadas com sucesso!');
                redirect(site_url('mapos/configurar'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um errro.</div>';
            }
        }

        $this->data['view'] = 'mapos/configurar';

        return $this->layout();
    }

    public function atualizarBanco()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }

        $this->load->library('migration');

        if ($this->migration->latest() === false) {
            $this->session->set_flashdata('error', $this->migration->error_string());
        } else {
            $this->session->set_flashdata('success', 'Banco de dados atualizado com sucesso!');
        }

        return redirect(site_url('mapos/configurar'));
    }

    public function atualizarMapos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }

        $this->load->library('github_updater');

        if (!$this->github_updater->has_update()) {
            $this->session->set_flashdata('success', 'Seu Amura OS já está atualizado!');

            return redirect(site_url('sistema/configurar'));
        }

        $success = $this->github_updater->update();

        if ($success) {
            $this->session->set_flashdata('success', 'Amura OS atualizado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao atualizar o Amura OS!');
        }

        return redirect(site_url('sistema/configurar'));
    }

    public function calendario()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }
        $this->load->model('os_model');
        $tipoFiltro = $this->input->get('tipo') ?: 'todos';
        $status = $this->input->get('status') ?: null;
        $start = $this->input->get('start') ?: date('Y-m-01');
        $end = $this->input->get('end') ?: date('Y-m-t');

        $events = [];

        // 1. Ordens de Serviço
        if ($tipoFiltro === 'todos' || $tipoFiltro === 'os') {
            $allOs = $this->mapos_model->calendario($start, $end, $status);
            foreach ($allOs as $os) {
                switch ($os->status) {
                    case 'Aberto':
                        $cor = '#00cd00';
                        break;
                    case 'Negociação':
                        $cor = '#AEB404';
                        break;
                    case 'Em Andamento':
                        $cor = '#436eee';
                        break;
                    case 'Orçamento':
                        $cor = '#CDB380';
                        break;
                    case 'Cancelado':
                        $cor = '#CD0000';
                        break;
                    case 'Finalizado':
                        $cor = '#256';
                        break;
                    case 'Faturado':
                        $cor = '#B266FF';
                        break;
                    case 'Aguardando Peças':
                        $cor = '#FF7F00';
                        break;
                    case 'Aprovado':
                        $cor = '#808080';
                        break;
                    default:
                        $cor = '#E0E4CC';
                        break;
                }

                $events[] = [
                    'id' => 'os_' . $os->idOs,
                    'title' => "OS #{$os->idOs} - {$os->nomeCliente}",
                    'start' => $os->dataFinal,
                    'end' => $os->dataFinal,
                    'color' => $cor,
                    'editable' => true,
                    'extendedProps' => [
                        'tipo' => 'os',
                        'rawId' => $os->idOs,
                        'id' => $os->idOs,
                        'cliente' => '<b>Cliente:</b> ' . $os->nomeCliente,
                        'dataInicial' => '<b>Data Inicial:</b> ' . date('d/m/Y', strtotime($os->dataInicial)),
                        'dataFinal' => '<b>Data Final:</b> ' . date('d/m/Y', strtotime($os->dataFinal)),
                        'garantia' => '<b>Garantia:</b> ' . $os->garantia . ' dias',
                        'status' => '<b>Status da OS:</b> ' . $os->status,
                        'description' => '<b>Descrição/Produto:</b> ' . strip_tags(html_entity_decode($os->descricaoProduto)),
                        'defeito' => '<b>Defeito:</b> ' . strip_tags(html_entity_decode($os->defeito)),
                        'observacoes' => '<b>Observações:</b> ' . strip_tags(html_entity_decode($os->observacoes)),
                        'subtotal' => '<br><b>Subtotal:</b> R$ ' . number_format($os->totalProdutos + $os->totalServicos, 2, ',', '.'),
                        'desconto' => '<b>Desconto:</b> -R$ ' . ($os->desconto > 0 ? number_format(($os->totalProdutos + $os->totalServicos) - $os->valor_desconto, 2, ',', '.') : number_format($os->desconto, 2, ',', '.')),
                        'total' => '<b>Total:</b> R$ ' . ($os->valor_desconto == 0 ? number_format($os->totalProdutos + $os->totalServicos, 2, ',', '.') : number_format($os->valor_desconto, 2, ',', '.')),
                        'faturado' => '<br><b>Faturado:</b> ' . ($os->faturado ? 'SIM' : 'PENDENTE'),
                        'editar' => $this->os_model->isEditable($os->idOs),
                    ],
                ];
            }
        }

        // 2. Compromissos e Lembretes
        if ($tipoFiltro === 'todos' || $tipoFiltro === 'compromissos') {
            $compromissos = $this->mapos_model->getCompromissosCalendario($start, $end);
            foreach ($compromissos as $comp) {
                $events[] = [
                    'id' => 'comp_' . $comp->idCompromisso,
                    'title' => "📌 {$comp->titulo}",
                    'start' => $comp->data_inicio,
                    'end' => $comp->data_fim ?: $comp->data_inicio,
                    'color' => $comp->cor ?: '#ff9204',
                    'editable' => true,
                    'extendedProps' => [
                        'tipo' => 'compromisso',
                        'rawId' => $comp->idCompromisso,
                        'titulo' => $comp->titulo,
                        'descricao' => $comp->descricao,
                        'data_inicio' => date('d/m/Y H:i', strtotime($comp->data_inicio)),
                        'status' => $comp->status,
                        'usuario' => $comp->nomeUsuario ?: 'Equipe',
                    ],
                ];
            }
        }

        // 3. Vencimentos Financeiros (Contas a Pagar e Receber)
        if ($tipoFiltro === 'todos' || $tipoFiltro === 'financeiro') {
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) {
                $lancamentos = $this->mapos_model->getLancamentosCalendario($start, $end);
                foreach ($lancamentos as $lanc) {
                    $isReceita = ($lanc->tipo === 'receita');
                    $isPago = (bool)$lanc->baixado;
                    $corFin = $isReceita ? '#10b981' : '#ef4444';
                    $prefixo = $isReceita ? '💰 REC: ' : '💸 PAG: ';
                    $statusTxt = $isPago ? 'Baixado' : 'Pendente';
                    $valorFmt = number_format($lanc->valor_desconto > 0 ? $lanc->valor_desconto : $lanc->valor, 2, ',', '.');

                    $events[] = [
                        'id' => 'fin_' . $lanc->idLancamentos,
                        'title' => "{$prefixo}{$lanc->cliente_fornecedor} (R$ {$valorFmt})",
                        'start' => $lanc->data_vencimento,
                        'end' => $lanc->data_vencimento,
                        'color' => $corFin,
                        'editable' => false,
                        'extendedProps' => [
                            'tipo' => 'financeiro',
                            'rawId' => $lanc->idLancamentos,
                            'tipoFin' => ucfirst($lanc->tipo),
                            'cliente_fornecedor' => $lanc->cliente_fornecedor,
                            'descricao' => $lanc->descricao,
                            'vencimento' => date('d/m/Y', strtotime($lanc->data_vencimento)),
                            'valor' => 'R$ ' . $valorFmt,
                            'statusFin' => $statusTxt,
                        ],
                    ];
                }
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($events));
    }

    public function reprogramarDataAjax()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Sem permissão.']));
        }

        $tipo = $this->input->post('tipo');
        $id = (int)$this->input->post('id');
        $novaData = $this->input->post('novaData');

        if (!$id || !$novaData) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Dados inválidos.']));
        }

        if ($tipo === 'os') {
            $dataFormatted = date('Y-m-d', strtotime($novaData));
            $this->mapos_model->atualizarDataOs($id, $dataFormatted);
            return $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => "Prazo da OS #{$id} reprogramado para " . date('d/m/Y', strtotime($dataFormatted)) . "!"
            ]));
        } elseif ($tipo === 'compromisso') {
            $dataFormatted = date('Y-m-d H:i:s', strtotime($novaData));
            $this->mapos_model->atualizarDataCompromisso($id, $dataFormatted);
            return $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => "Compromisso reprogramado com sucesso!"
            ]));
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Tipo não suporta reprogramação por arrasto.']));
    }

    public function adicionarCompromissoAjax()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Sem permissão.']));
        }

        $titulo = trim($this->input->post('titulo'));
        $dataInicio = $this->input->post('data_inicio');
        $horaInicio = $this->input->post('hora_inicio') ?: '09:00';
        $descricao = trim($this->input->post('descricao'));
        $cor = $this->input->post('cor') ?: '#ff9204';

        if (empty($titulo) || empty($dataInicio)) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Título e Data são obrigatórios.']));
        }

        $dataCompleta = date('Y-m-d H:i:s', strtotime($dataInicio . ' ' . $horaInicio));

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'data_inicio' => $dataCompleta,
            'cor' => $cor,
            'status' => 'Pendente',
            'usuarios_id' => $this->session->userdata('id_admin') ?: $this->session->userdata('id'),
            'data_cadastro' => date('Y-m-d H:i:s')
        ];

        $res = $this->mapos_model->adicionarCompromisso($data);

        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => (bool)$res,
            'message' => $res ? 'Compromisso agendado com sucesso!' : 'Erro ao agendar compromisso.'
        ]));
    }

    public function excluirCompromissoAjax()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Sem permissão.']));
        }

        $id = (int)$this->input->post('id');
        if ($id) {
            $this->mapos_model->excluirCompromisso($id);
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false]));
    }

    private function editDontEnv(array $data)
    {
        $env_file_path = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . '.env';
        $env_file = file_get_contents($env_file_path);

        foreach ($data as $constante => $valor) {
            // Cada valor vira uma linha do .env. Uma quebra de linha no POST
            // permitiria acrescentar outras variáveis de ambiente à vontade.
            $valor = str_replace(["\r", "\n"], '', (string) $valor);

            if ($constante == 'API_JWT_KEY' && $valor == 'sim') {
                $base64 = base64_encode(openssl_random_pseudo_bytes(32));
                $valor = '"' . $base64 . '"';
                $env_file = str_replace("$constante=" . '"' . $_ENV[$constante] . '"', "$constante={$valor}", $env_file);
            } else {
                if (isset($_ENV[$constante])) {
                    $env_file = str_replace("$constante={$_ENV[$constante]}", "$constante={$valor}", $env_file);
                } else {
                    file_put_contents($env_file_path, $env_file . "\n{$constante}={$valor}\n");
                    $env_file = file_get_contents($env_file_path);
                }
            }
        }
        return file_put_contents($env_file_path, $env_file) ? true : false;
    }
}
