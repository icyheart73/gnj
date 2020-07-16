<?php

/**
 * Uninstaller
 *
 * @author ganjesoft <hello.ganjesoft@gmail.com>
 * @license MIT
 */

// Make sure plugin container is available.
if (!class_exists('GanjeAddonsForElementor\Plugin', false)) {
    require __DIR__.'/ganje-addons-for-elementor.php';
}

// Delete all settings.
delete_option(GanjeAddonsForElementor\Plugin::OPTION_NAME);
