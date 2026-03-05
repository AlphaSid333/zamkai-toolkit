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
                <div style = "display:flex">
                    <button class="button ztk-install-plugin-btn">Install Now</button>
                    <div class = "ztk-install-plugin-spn spinner"></div>
                </div>
                <p></p>
            </div>
            
            <div class="card" style="min-width: 300px;">
                <h2>WP Reset</h2>
                <p>For complete site resets.</p>
                <div style = "display:flex">
                    <button class="button ztk-install-plugin-btn">Install Now</button>
                    <div class = "ztk-install-plugin-spn spinner"></div>
                </div>
                <p></p>
            </div>

            <div class="card" style="min-width: 300px;">
                <h2>Email Logs</h2>
                <p>Check outgoing emails without SMTP.</p>
                <div style = "display:flex">
                    <button class="button ztk-install-plugin-btn">Install Now</button>
                    <div class = "ztk-install-plugin-spn spinner"></div>
                </div>
                <p></p>
            </div>
            
            <!-- Add more cards as needed -->
        </div>
    </div>
