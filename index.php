<?php

/**
 * @defgroup plugins_generic_confluence
 */
 
/**
 * @file plugins/generic/confluence/index.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_confluence
 * @brief Wrapper for Confluence plugin.
 *
 */

require_once('ConfluencePlugin.inc.php');

return new ConfluencePlugin();

?>
