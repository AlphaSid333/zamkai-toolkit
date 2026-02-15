<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function zkytLogPreview(){

$log_file = ABSPATH . "wp-content/debug.log";

    if ( isset($_POST['ztk_clear_log_btn']) ) {
        $empty = "";
        file_put_contents($log_file, $empty);
        wp_redirect([]); //unable to add a notice here, for some reason it doesn't show up.
    }
    if(file_exists($log_file)){
        $logContent = file_get_contents($log_file);
        ?>
        <div id = "ztk-log-preview" class="ztk-log-card">
            <div class="ztk-title" style ="display: flex; align-items: center;" ><h3>Log File Preview</h3>
                <div class = "ztk-clear-log-btn" style= "padding: 0px 10px 0px 10px;">
                    <form method="post" style="display: inline;"> <button
                    type="submit" 
                    name="ztk_clear_log_btn" 
                    class="button button-primary button-large"> Clear logs</button>
                </form> 
            </div>
        </div>
            <p style = "margin: 0px;" >Preview of your log file.</p>
            <!-- Text preview in <pre> for formatting -->
                <pre style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; max-height: 600px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                    <?php echo esc_html($logContent); ?>
                </pre>
            </div> <?
    }
    else{
        echo "Ran into an error here";
    }
}