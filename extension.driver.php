<?php
	
	/**
	 * @package aloha_formatter
	 */
	
	/**
	 * Provide an Aloha WYSIWYG editor.
	 */
	class Extension_Aloha_Formatter extends Extension {
		/**
		 * True if the editor has been included.
		 */
		protected $included;
		
		/**
		 * Extension information.
		 */
		public function about() {
			return array(
				'name'			=> 'Text Formatter: Aloha',
				'version'		=> '0.1',
				'release-date'	=> '2011-05-05',
				'author'		=> array(
					array(
						'name'			=> 'Rowan Lewis',
						'website'		=> 'http://rowanlewis.com/',
						'email'			=> 'me@rowanlewis.com'
					)
				)
			);
		}
		
		/**
		 * Listen for these delegates.
		 */
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'viewPreferences'
				),
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => 'actionsPreferences'
				),
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'ModifyTextareaFieldPublishWidget',
					'callback'	=> 'includeEditor'
				),
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'ModifyTextBoxFullFieldPublishWidget',
					'callback'	=> 'includeEditor'
				)
			);
		}
		
		/**
		 * List available plugins.
		 */
		public function listAvailablePlugins() {
			return array(
				'com.gentics.aloha.plugins.Format' => array(
					'name'		=> 'Basic Formatting',
					'required'	=> true
				),
				'com.gentics.aloha.plugins.Table' => array(
					'name'		=> 'Table Formatting',
					'required'	=> false
				),
				'com.gentics.aloha.plugins.List' => array(
					'name'		=> 'List Formatting',
					'required'	=> false
				)
			);
		}
		
		/**
		 * Apply the editor to a textbox or textarea field.
		 */
		public function includeEditor($context) {
			var_dump($context['field']->get('formatter'));
			exit;
			
			$element = $context['textarea'];
			$classes = explode(' ', $element->getAttribute('class'));
			$classes[] = 'aloha-editor';
			$element->setAttribute('class', implode(' ', $classes));
			
			if ($this->included === true) return;
			
			$this->included = true;
			
			$page = Symphony::Engine()->Page;
			$page->addScriptToHead(URL . '/extensions/aloha_formatter/assets/aloha/aloha.js');
			
			foreach ($this->listAvailablePlugins() as $id => $info) {
				$page->addScriptToHead(sprintf(
					'%s/extensions/aloha_formatter/assets/aloha/plugins/%s/plugin.js',
					URL, $id
				));
			}
			
			$page->addStylesheetToHead(URL . '/extensions/aloha_formatter/assets/publish.css');
			$page->addScriptToHead(URL . '/extensions/aloha_formatter/assets/publish.js');
		}
	}

?>