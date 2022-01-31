<?php

/**
 * @file plugins/generic/confluence/ConfluencePlugin.inc.php
 * includes the scripts for image gallery and video player in header of each article page
 *
 * Copyright (c) 2022 Freie UniversitÃ¤t Berlin
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
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
	/**
	 * @copydoc Plugin::register()
	 */	 
	function register($category, $path, $mainContextId = null) {

		$success = parent::register($category, $path, $mainContextId);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
		if ($success && $this->getEnabled($mainContextId)) {
			HookRegistry::register ('TemplateManager::display', array($this, 'addScriptsToArticleHeader'));
			//HookRegistry::register('ArticleHandler::view', array($this, 'getArticleTemplateData'));
		}
		return $success;
	}

	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	function getDisplayName() {
		return __('plugins.generic.confluence.displayName');
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	function getDescription() {
		return __('plugins.generic.confluence.description');
	}

	/**  
	 * Add js and css for image gallery, video player and column layout to the header of each article
	 */	 
	function addScriptsToArticleHeader($hookName, $params){
		
		$templateMgr =& $params[0];
		$template =& $params[1];

		$baseUrl = $templateMgr->get_template_vars('baseUrl');
		$pluginPath = $this->getPluginPath();
		
		if ($template == 'frontend/pages/article.tpl') {
			
		
			$output = "";
			$url = $baseUrl.'/'.$pluginPath;
						
			$output .= '<!-- CeDiS Video.JS Library -->
						<link href="'.$url.'/video-player/video-js.css" rel="stylesheet">
						<script type="text/javascript" src="'.$url.'/video-player/video.js"></script>
						<!-- CeDiS End Video.JS Library -->';
				
			$output .='<!-- CeDiS: fancyBox -->
						<!-- fancyBox-Core -->
						<script src="'.$url.'/fancyBox/lib/jquery-1.11.3.min.js" type="text/javascript"></script>
						<link media="screen" type="text/css" href="'.$url.'/fancyBox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" />
						<script src="'.$url.'/fancyBox/source/jquery.fancybox.js?v=2.1.5" type="text/javascript"></script>
						<!-- Optionally add helpers - button, thumbnail and/or media -->
						<link rel="stylesheet" href="'.$url.'/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
						<script type="text/javascript" src="'.$url.'/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
						<script type="text/javascript" src="'.$url.'/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
						<link rel="stylesheet" href="'.$url.'/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
						<script type="text/javascript" src="'.$url.'/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
						<link rel="stylesheet" href="'.$url.'/fancyBox/fancybox.css" type="text/css" media="screen" />
						<!-- CeDiS: End fancyBox -->
						<!-- CeDiS: Column layout -->
						<link rel="stylesheet" href="'.$url.'/style.css" type="text/css" media="screen" />
						<!-- CeDiS: End Column layout -->';
						
			$templateMgr->addHeader('custom', $output);
		}
		return false;
	}
	
}
?>
