<?php

/**
 * Uninstaller
 *
 * @author cleversoft <hello.cleversoft@gmail.com>
 * @license MIT
 */

// Make sure plugin container is available.
if (!class_exists('CleverAddonsForElementor\Plugin', false)) {
    require __DIR__.'/clever-addons-for-elementor.php';
}

// Delete all settings.
delete_option(CleverAddonsForElementor\Plugin::OPTION_NAME);
