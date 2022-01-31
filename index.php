<?php

/**
 * @defgroup plugins_generic_confluence
 */
 
/**
 * @file plugins/generic/confluence/index.php
 *
 * Copyright (c) 2022 Freie Universität Berlin
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_confluence
 * @brief Wrapper for Confluence plugin.
 *
 */

require_once('ConfluencePlugin.inc.php');

return new ConfluencePlugin();

?>
