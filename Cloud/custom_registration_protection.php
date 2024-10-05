<?php

/**
 * 
 Crea un archivo de hook llamado custom_registration_protection.php en el directorio includes/hooks/.
este codigo mitiga los bot
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

/**
 * Hook to prevent bots from bypassing registration
 */
add_hook('ClientAreaPageRegister', 1, function($vars) {

    // Honeypot field: a hidden field that should be left empty by legitimate users
    $honeypotField = isset($_POST['extra_field']) ? $_POST['extra_field'] : '';

    // Block registration if the honeypot field is filled (bot detected)
    if (!empty($honeypotField)) {
        return array(
            'templateVariables' => array(
                'error' => 'Registration failed: Bot activity detected.',
            ),
        );
    }

    // Validate other fields for possible bot patterns (e.g., rapid form submission)
    if (time() - $_SESSION['form_timestamp'] < 5) {
        // If the form is submitted too quickly, it's likely a bot
        return array(
            'templateVariables' => array(
                'error' => 'Registration failed: Suspicious activity detected.',
            ),
        );
    }
});

/**
 * Add Honeypot field and timestamp in registration form
 */
add_hook('ClientAreaFooterOutput', 1, function($vars) {
    // Set a timestamp for when the form is loaded (used for submission speed validation)
    $_SESSION['form_timestamp'] = time();

    return <<<HTML
<input type="text" name="extra_field" style="display:none;">
HTML;
});
