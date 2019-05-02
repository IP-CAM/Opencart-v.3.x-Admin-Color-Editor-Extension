<?php
class ControllerExtensionModuleColors extends Controller {

    public function index() {
        $this->load->language('extension/module/colors');
        
		$this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/colors');
        $this->load->model('setting/setting');
        
        // Llama por única vez al método install debido a que opencart no lo hace cuando se instala la extensión, solo lo hace por medio del panel de extensiones.
        if (!$this->config->get('module_colors_status') && $this->config->get('module_colors_status') !== '0') {
            $this->install();
        }

        $data = [];
        $data['module_colors_status'] = $this->config->get('module_colors_status');

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && $data['module_colors_status']) {
            $this->model_extension_module_colors->updateColors($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/colors', 'user_token=' . $this->session->data['user_token'], true));
            return;
		}

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/colors', 'user_token=' . $this->session->data['user_token'], true)
		);

        $data['user_token'] = $this->session->data['user_token'];
        $data['cancel'] = $this->url->link('extension/module/colors', 'user_token=' . $this->session->data['user_token'], true);
        $data['storefront_url'] = HTTP_CATALOG;

        $colors = $this->model_extension_module_colors->getColors();

        $data['color_primary'] = $colors['color_primary'];
        $data['color_primary_variant'] = $colors['color_primary_variant'];
        $data['color_secondary'] = $colors['color_secondary'];
        $data['color_secondary_variant'] = $colors['color_secondary_variant'];
        $data['color_text_primary'] = $colors['color_text_primary'];
        $data['color_text_secondary'] = $colors['color_text_secondary'];
        $data['color_paragraphs'] = $colors['color_paragraphs'];
        $data['color_edges'] = $colors['color_edges'];
        $data['color_surface_primary'] = $colors['color_surface_primary'];
        $data['color_surface_secondary'] = $colors['color_surface_secondary'];
        $data['color_alternative'] = $colors['color_alternative'];
        $data['color_titles'] = $colors['color_titles'];

        if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else
			$data['success'] = '';

        //$this->config->set('template_cache', false);
        $this->response->setOutput($this->load->view('extension/module/colors', $data));
        //$this->config->set('template_cache', true);
    }
    
    protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/colors')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->isValidColor($this->request->post['color_primary'])) {
			$this->error['color_primary']= $this->language->get('txterror_color_primary');
        }
		if (!$this->isValidColor($this->request->post['color_primary_variant'])) {
			$this->error['color_primary_variant']= $this->language->get('txterror_color_primary_variant');
        }
        if (!$this->isValidColor($this->request->post['color_secondary'])) {
			$this->error['color_secondary']= $this->language->get('txterror_color_secondary');
        }
        if (!$this->isValidColor($this->request->post['color_secondary_variant'])) {
			$this->error['color_secondary_variant']= $this->language->get('txterror_color_secondary_variant');
        }
        if (!$this->isValidColor($this->request->post['color_text_primary'])) {
			$this->error['color_text_primary']= $this->language->get('txterror_color_text_primary');
        }
        if (!$this->isValidColor($this->request->post['color_text_secondary'])) {
			$this->error['color_text_secondary']= $this->language->get('txterror_color_text_secondary');
        }
        if (!$this->isValidColor($this->request->post['color_paragraphs'])) {
			$this->error['color_paragraphs']= $this->language->get('txterror_color_paragraphs');
        }
        if (!$this->isValidColor($this->request->post['color_edges'])) {
			$this->error['color_edges']= $this->language->get('txterror_color_edges');
        }
        if (!$this->isValidColor($this->request->post['color_surface_primary'])) {
			$this->error['color_surface_primary']= $this->language->get('txterror_color_surface_primary');
        }
        if (!$this->isValidColor($this->request->post['color_surface_secondary'])) {
			$this->error['color_surface_secondary']= $this->language->get('txterror_color_surface_secondary');
        }
        if (!$this->isValidColor($this->request->post['color_alternative'])) {
			$this->error['color_alternative']= $this->language->get('txterror_color_alternative');
        }
        if (!$this->isValidColor($this->request->post['color_titles'])) {
			$this->error['color_titles']= $this->language->get('txterror_color_titles');
        }
        
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
    }
    
    private function isValidColor($color) {
        return !empty($color) && preg_match("/^#[0-9a-f]{6}$/i", $color) ? true : false;
    }

    public function generate() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->load->model('extension/module/colors');
            $colors = $this->model_extension_module_colors->sanitizeColors($this->request->post);
			$stylesheet = $this->model_extension_module_colors->generateStylesheet($colors);
            $this->response->addHeader('Content-Type: text/css');
            $this->response->setOutput($stylesheet);
		}
    }

    public function install() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_colors', ['module_colors_status'=>1]);
    }
 
    public function uninstall() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('module_colors');
    }
}