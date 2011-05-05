<?php
	
	/**
	 * @package libs
	 */
	
	require_once EXTENSIONS . '/text_formatters/lib/class.improvedtextformatter.php';
	
	class FormatterAloha extends ImprovedTextFormatter {
		public function about() {
			return array(
				'name'						=> 'Aloha',
				'author'					=> array(
					'name'						=> 'Rowan Lewis',
					'website'					=> 'http://rowanlewis.com/',
					'email'						=> 'me@rowanlewis.com'
				),
				'description'				=> 'Edit HTML with the Aloha WYSIWYG editor.'
			);
		}
		
		/**
		 * Given an input, apply the formatter and return the result.
		 * @param string $source
		 * @return string
		 */
		public function run($source) {
			return $this->runCleanup($source);
		}
		
		/**
		 * Use HTML Tidy to cleanup the source.
		 * @param $source The HTML string to tidy.
		 */
		protected function runCleanup(&$source) {
			$tidy = new Tidy();
			$tidy->parseString(
				$source, array(
					'drop-font-tags'				=> true,
					'drop-proprietary-attributes'	=> true,
					'hide-comments'					=> true,
					'numeric-entities'				=> true,
					'output-xhtml'					=> true,
					'wrap'							=> 0,
					
					// Stuff to get rid of awful word this:
					'bare'							=> true,
					'word-2000'						=> true,
					
					// HTML5 Elements:
					'new-blocklevel-tags'			=> 'section nav article aside hgroup header footer figure figcaption ruby video audio canvas details datagrid summary menu',
					'new-inline-tags'				=> 'time mark rt rp output progress meter',
					'new-empty-tags'				=> 'wbr source keygen command'
				), 'utf8'
			);
			
			$source = $tidy->body()->value;
		}
	}
	
?>