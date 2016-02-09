<?php

/**
 * @file plugins/generic/confluence/ConfluencePlugin.inc.php
 * includes the scripts for image gallery and video player in header of each article page
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
			
			// add css in the article header template
			HookRegistry::register ('TemplateManager::display', array($this, 'addScriptsToArticleHeader'));
		
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
	

	/**  
	 * Add js and css for image gallery, video player and column layout to the header of each article
	 */
	function addScriptsToArticleHeader($hookName, $params){
		$smarty =& $params[0];
		$template =& $params[1];
		
		$templateMgr =& TemplateManager::getManager();
		$baseUrl = $templateMgr->get_template_vars('baseUrl');
		$pluginPath = $this->getPluginPath();
		
		
		if ($template == 'article/article.tpl') {
				$output = $smarty->get_template_vars('additionalHeadData');

				$url = $baseUrl.'/'.$pluginPath;
				
				
				$output .= '<!-- CeDiS Video.JS Library -->
							<link href="'.$url.'/video-player/video-js.css" rel="stylesheet">
							<script type="text/javascript" src="'.$url.'/video-player/video.js"></script>
							<!-- CeDiS End Video.JS Library -->';
				
				$output .='<!-- CeDiS: fancyBox -->
							<!-- fancyBox-Core -->
							<script src="'.$url.'/fancybox/lib/jquery-1.11.3.min.js" type="text/javascript"></script>
							<link media="screen" type="text/css" href="'.$url.'/fancybox/source/jquery.fancybox.css?v=2.1.5" rel="stylesheet" />
							<script src="'.$url.'/fancybox/source/jquery.fancybox.js?v=2.1.5" type="text/javascript"></script>
							<!-- Optionally add helpers - button, thumbnail and/or media -->
							<link rel="stylesheet" href="'.$url.'/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
							<script type="text/javascript" src="'.$url.'/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
							<script type="text/javascript" src="'.$url.'/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
							<link rel="stylesheet" href="'.$url.'/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
							<script type="text/javascript" src="'.$url.'/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
							<link rel="stylesheet" href="'.$url.'/fancybox/fancybox.css" type="text/css" media="screen" />
							<!-- CeDiS: End fancyBox -->
							<!-- CeDiS: Column layout -->
							<link rel="stylesheet" href="'.$url.'/style.css" type="text/css" media="screen" />
							<!-- CeDiS: End Column layout -->';
				
				$smarty->assign('additionalHeadData', $output);
			}
			return false;
	}
	
}
?>
