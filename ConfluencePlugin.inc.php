<?php

/**
 * @file plugins/generic/confluence/ConfluencePlugin.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ConfluencePlugin
 * @ingroup plugins_generic_Confluence
 *
 * @brief Confluence plugin class
 */


import('lib.pkp.classes.plugins.GenericPlugin');

class ConfluencePlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			// hook added in \templates\article\header.tpl
			HookRegistry::register('Templates::Article::Header::Script', array($this, 'addFancybox'));
			// existing hook used \templates\article\footer.tpl
			HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'activateFancyBox'));
		}
		return $success;
	}

	function getDisplayName() {
		return __('plugins.generic.confluence.displayName');
	}

	function getDescription() {
		return __('plugins.generic.confluence.description');
	}

	/**
	 * Get the name of the settings file to be installed site-wide when
	 * OJS is installed.
	 * @return string
	 */
	function getInstallSitePluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}	
	
	/** TODO 
	 * Insert Fancybox to the header of the article page 
	 * @return string
	 */
	function addFancybox($hookName, $params){
		
		$output =& $params[2];
		$templateMgr =& TemplateManager::getManager();
		$baseUrl = $templateMgr->get_template_vars('baseUrl');
		
		if ($this->getEnabled()) {
			$output .= '<!-- Add jQuery library --><script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>';
			$output .= '<!-- Add fancyBox --><link rel="stylesheet" href="'.$baseUrl.'/plugins/generic/confluence/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />';
			$output .= '<script type="text/javascript" src="'.$baseUrl.'/plugins/generic/confluence/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>';
		}
		return false;
	
	}
	
	/**
	 * Insert own JavaScript to footer of the article page 
	 * TODO: when there is a better solution to manipulate the HTML file, this will only be one line: $('.gallery-link').fancybox();	
	 * @return string
	 */
	function activateFancyBox($hookName, $params){
		
		$output =& $params[2];
		$templateMgr =& TemplateManager::getManager();
		$baseUrl = $templateMgr->get_template_vars('baseUrl');
		
		if ($this->getEnabled()) {
			$output .= '<script type="text/javascript" src="'.$baseUrl.'/plugins/generic/confluence/imageGallery.js"></script>';
		}
		return false;
	
	}
	

	/**
	 * Insert COinS tag. - not used
	 */
	function insertFooter($hookName, $params) {
		if ($this->getEnabled()) {
			$smarty =& $params[1];
			$output =& $params[2];
			$templateMgr =& TemplateManager::getManager();

			$article = $templateMgr->get_template_vars('article');
			$journal = $templateMgr->get_template_vars('currentJournal');
			$issue = $templateMgr->get_template_vars('issue');

			$authors = $article->getAuthors();
			$firstAuthor =& $authors[0];

			$vars = array(
				array('ctx_ver', 'Z39.88-2004'),
				array('rft_id', Request::url(null, 'article', 'view', $article->getId())),
				array('rft_val_fmt', 'info:ofi/fmt:kev:mtx:journal'),
				array('rft.genre', 'article'),
				array('rft.title', $journal->getLocalizedTitle()),
				array('rft.jtitle', $journal->getLocalizedTitle()),
				array('rft.atitle', $article->getLocalizedTitle()),
				array('rft.artnum', $article->getBestArticleId()),
				array('rft.stitle', $journal->getLocalizedSetting('abbreviation')),
				array('rft.volume', $issue->getVolume()),
				array('rft.issue', $issue->getNumber()),
				array('rft.aulast', $firstAuthor->getLastName()),
				array('rft.aufirst', $firstAuthor->getFirstName()),
				array('rft.auinit', $firstAuthor->getMiddleName())
			);

			$datePublished = $article->getDatePublished();
			if (!$datePublished) $datePublished = $issue->getDatePublished();
			if ($datePublished) {
				$vars[] = array('rft.date', date('Y-m-d', strtotime($datePublished)));
			}

			foreach ($authors as $author) {
				$vars[] = array('rft.au', $author->getFullName());
			}

			if ($doi = $article->getPubId('doi')) $vars[] = array('rft_id', 'info:doi/' . $doi);
			if ($article->getPages()) $vars[] = array('rft.pages', $article->getPages());
			if ($journal->getSetting('printIssn')) $vars[] = array('rft.issn', $journal->getSetting('printIssn'));
			if ($journal->getSetting('onlineIssn')) $vars[] = array('rft.eissn', $journal->getSetting('onlineIssn'));

			$title = '';
			foreach ($vars as $entries) {
				list($name, $value) = $entries;
				$title .= $name . '=' . urlencode($value) . '&';
			}
			$title = htmlentities(substr($title, 0, -1));

			$output .= "<span class=\"Z3988\" title=\"$title\"></span>\n";
		}
		return false;
	}
}
?>
