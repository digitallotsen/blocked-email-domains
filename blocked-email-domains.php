<?php
/**
 * Plugin Name: Blocked Email Domains for Fluent Forms
 * Description: Sperrt bestimmte E-Mail-Domains in Fluent Forms, damit bestimmte gezielte Spammer ausgeschlossen werden.
 * Version: 1.0.0
 * Author: digitallotsen GmbH
 * Author URI: https://digitallotsen.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: blocked-email-domains
 */

if (!defined('ABSPATH')) exit; // Sicherheitscheck

// === 1. ADMIN-MENÜ REGISTRIEREN ===
add_action('admin_menu', function () {
    add_options_page(
        'Gesperrte E-Mail-Domains',   // Seitentitel
        'Gesperrte Domains',           // Menü-Label
        'manage_options',              // Berechtigung (nur Admins)
        'blocked-email-domains',       // Slug
        'bed_settings_page'            // Callback-Funktion
    );
});

// === 2. EINSTELLUNGEN REGISTRIEREN ===
add_action('admin_init', function () {
    register_setting('bed_settings_group', 'bed_blocked_domains', [
        'sanitize_callback' => 'sanitize_textarea_field'
    ]);
});

// === 3. ADMIN-SEITE AUSGEBEN ===
function bed_settings_page() {
    $domains = get_option('bed_blocked_domains', '');
    ?>
    <div class="wrap">
        <h1>Gesperrte E-Mail-Domains</h1>
        <p>Eine Domain pro Zeile eingeben, z.B. <code>spam.com</code></p>
        <form method="post" action="options.php">
            <?php settings_fields('bed_settings_group'); ?>
            <textarea
                name="bed_blocked_domains"
                rows="10"
                cols="50"
                class="large-text code"
                placeholder="spam.com&#10;example.com&#10;buildyourwpsites.com"
            ><?php echo esc_textarea($domains); ?></textarea>
            <?php submit_button('Domains speichern'); ?>
        </form>

        <?php if (!empty($domains)): ?>
        <h2>Aktuell gesperrte Domains</h2>
        <ul>
            <?php foreach (bed_get_blocked_domains() as $domain): ?>
                <li><code><?php echo esc_html($domain); ?></code></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php
}

// === 4. HILFSFUNKTION: Domains als Array holen ===
function bed_get_blocked_domains() {
    $raw = get_option('bed_blocked_domains', '');
    if (empty($raw)) return [];

    $domains = explode("\n", $raw);             // Zeilenumbruch splitten
    $domains = array_map('trim', $domains);     // Leerzeichen entfernen
    $domains = array_map('strtolower', $domains); // Kleinbuchstaben
    $domains = array_filter($domains);          // Leere Zeilen raus
    return $domains;
}

// === 5. FLUENT FORMS VALIDIERUNG ===
add_filter('fluentform/validate_input_item_input_email', function ($error, $field, $formData, $fields, $form) {
    $blockedDomains = bed_get_blocked_domains();
    if (empty($blockedDomains)) return $error;

    $fieldName = $field['name'];
    if (empty($formData[$fieldName])) return $error;

    $parts = explode('@', $formData[$fieldName]);
    $inputDomain = strtolower(trim(array_pop($parts)));

    if (in_array($inputDomain, $blockedDomains)) {
        return [
            'Wir reagieren nicht auf Formular-Spam. Spar Dir die Mühe. / We do not respond to form spam. Save yourself the effort.'
        ];
    }

    return $error;
}, 10, 5);