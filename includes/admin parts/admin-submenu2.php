<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Renders the sub menu quick tools page for the Zamkai Toolkit plugin.
 */
?>
<div class="wrap">
    <h1>Quick Helper Plugins</h1>
        <div class="zkt-quick-install" style="display: flex; flex-wrap: wrap; gap: 20px;">
            <!-- Cards for Plugins -->
            <div class="card" style="min-width: 300px;">
                <h2>WPVivid Backup</h2>
                <p>For quick backup creation and restoration.</p>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=plugin1-slug&tab=search&type=term' ) ); ?>" class="button button-primary">Install Now</a>
                </p>
            </div>
            
            <div class="card" style="min-width: 300px;">
                <h2>WP Reset</h2>
                <p>For complete site resets.</p>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=plugin2-slug&tab=search&type=term' ) ); ?>" class="button button-primary">Install Now</a>
                </p>
            </div>

            <div class="card" style="min-width: 300px;">
                <h2>Email Logs</h2>
                <p>Check outgoing emails without SMTP.</p>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=plugin2-slug&tab=search&type=term' ) ); ?>" class="button button-primary">Install Now</a>
                </p>
            </div>
            
            <!-- Add more cards as needed -->
        </div>
    </div>
