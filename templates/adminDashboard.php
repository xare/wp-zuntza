<div class="wrap">
    <h1>Zuntza for WP plugin development DASHBOARD</h1>
    <?php settings_errors(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a></li>
        <li><a href="#tab-2">Updates</a></li>
        <li><a href="#tab-3">About</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=zuntza')); ?>" enctype="multipart/form-data">
                <?php
                /* settings_fields('zuntza_settings');
                do_settings_sections('zuntza');
                submit_button(); */
                ?>

                <h2>File Upload</h2>
                <input type="file" name="zuntza_uploaded_file" id="zuntza_uploaded_file">
                <?php

                wp_nonce_field('zuntza_upload_nonce', 'zuntza_upload_nonce');
                // Add this hidden field to trigger the file upload handling action
                echo '<input type="hidden" name="action" value="handle_file_upload">';
                submit_button('Upload File'); 
                ?>
            </form>
             <!-- Display the success message here -->
             <div id="upload-message"></div>
        </div>
        <div id="tab-2" class="tab-pane"></div>
        <div id="tab-3" class="tab-pane"></div>
    </div>
</div>