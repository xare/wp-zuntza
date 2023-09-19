<?php
/**
 * @package zuntza
 */

namespace Inc\Zuntza\Api\Callbacks;

use Exception;
use Inc\Zuntza\Base\BaseController;

 class AdminCallbacks extends BaseController {

  public function adminDashboard() {
    return require_once("$this->plugin_templates_path/adminDashboard.php");
  }

  public function handleFileUpload() {
    if ( isset( $_POST['action'] ) 
    && $_POST['action'] === 'handle_file_upload' 
    && isset( $_POST['zuntza_upload_nonce'] )
    && wp_verify_nonce( $_POST['zuntza_upload_nonce'], 'zuntza_upload_nonce' ) ) {
        $uploaded_file = $_FILES['zuntza_uploaded_file'];

        if ($uploaded_file['error'] == 0) {
            // Get the file name and extension
            $original_file_name = sanitize_file_name($uploaded_file['name']);
            // Generate a date and time stamp
            $date_time_stamp = date('d_m_Y_H_i');
            // Create a new file name with the date and time stamp
            $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . $date_time_stamp . '.' . pathinfo($original_file_name, PATHINFO_EXTENSION);

            $file_tmp_name = $uploaded_file['tmp_name'];

            // Define the target directory within wp-content/uploads where you want to store the file
            $target_directory = $this->upload_path;

            // Create the target directory if it doesn't exist
            if (!file_exists($target_directory)) {
                mkdir($target_directory, 0755, true);
            }

            // Move the uploaded file to the target directory
            $target_file = $target_directory . $new_file_name;
            try {
              move_uploaded_file($uploaded_file['tmp_name'], $target_file);
              // File upload successful - set a success admin notice
              add_settings_error('zuntza_upload', 'zuntza_upload_success', 'File uploaded successfully!', 'success');
          } catch( Exception $exception ) {
             // File upload failed - set an error admin notice
             add_settings_error('zuntza_upload', 'zuntza_upload_error', 'File upload failed. '. $exception->getMessage() . ' Please try again.', 'error');
          }

            // Optionally, you can store the file path or other details in your plugin settings or database
        } else {
          error_log("File upload error: " . $uploaded_file['error']);
        }
    } else {
      add_settings_error('zuntza_upload', 'zuntza_upload_error', 'File upload failed. Please try again.', 'error');
    }
}

public function displayAdminNotices() {
  settings_errors('zuntza_upload');
}
  
 }