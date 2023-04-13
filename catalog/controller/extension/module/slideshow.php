<?php

class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$template_folder = $this->config->get('theme_default_directory');
		$this->document->addStyle('catalog/view/theme/' . $template_folder . '/js/ls/css/lightslider.min.css');
		$this->document->addScript('catalog/view/theme/' . $template_folder . '/js/ls/js/lightslider.min.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];

		$data['module'] = $module++;

		return $this->load->view('extension/module/slideshow', $data);
	}
}
