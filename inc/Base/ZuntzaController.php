<?php
namespace Inc\Zuntza\Base;

use Inc\Zuntza\Base\BaseController;
use Inc\Zuntza\Api\SettingsApi;
use SplFileObject;

class ZuntzaController extends BaseController
{
    public function register() {
        error_log('ZuntzaController register method called.');
        //if( !$this->activated('zuntza')) return;

        error_log("Adding zuntza_form shortcode");  // Add this line
        add_shortcode( 'zuntza_form', [$this, 'zuntza_form'] );

        add_action('wp_ajax_get_provincia', [$this, 'get_provincia']);
        add_action('wp_ajax_nopriv_get_provincia', [$this, 'get_provincia']);

        add_action('wp_ajax_get_municipio', [$this, 'get_municipio']);
        add_action('wp_ajax_nopriv_get_municipio', [$this, 'get_municipio']);

        add_action('wp_ajax_get_calle', [$this, 'get_calle']);
        add_action('wp_ajax_nopriv_get_calle', [$this, 'get_calle']);

        add_action('wp_ajax_get_numero', [$this, 'get_numero']);
        add_action('wp_ajax_nopriv_get_numero', [$this, 'get_numero']);
    }

    
    public function get_provincia() {
        $data = $this->loadData();
        echo wp_send_json(array_unique(array_column($data, 'Provincia')));
    }

    public function get_municipio() {
        $data = $this->loadData();
        $selectedProvincia = array_unique(array_column($data, 'Provincia'))[$_POST['provinciaIndex']];
        $provinciaData = array_filter($data, function ($row) use ($selectedProvincia) {
            return $row['Provincia'] == $selectedProvincia;
        });
        echo wp_send_json(array_unique(array_column($provinciaData, 'Municipio')));
    }

    public function get_calle() {
        $data = $this->loadData();
        $selectedProvincia = array_unique(array_column($data, 'Provincia'))[$_POST['provinciaIndex']];
        $provinciaData = array_filter($data, function ($row) use ($selectedProvincia) {
            return $row['Provincia'] == $selectedProvincia;
        });
        $selectedMunicipio = array_unique(array_column($provinciaData, 'Municipio'))[$_POST['municipioIndex']];
        $municipioData = array_filter($provinciaData, function ($row) use ($selectedMunicipio) {
            return $row['Municipio'] == $selectedMunicipio;
        });
        echo wp_send_json(array_unique(array_column($municipioData, 'Calle')));
    }

    public function get_numero() {
        $data = $this->loadData();
        $selectedProvincia = array_unique(array_column($data, 'Provincia'))[$_POST['provinciaIndex']];
        $provinciaData = array_filter($data, function ($row) use ($selectedProvincia) {
            return $row['Provincia'] == $selectedProvincia;
        });
        $selectedMunicipio = array_unique(array_column($provinciaData, 'Municipio'))[$_POST['municipioIndex']];
        $municipioData = array_filter($provinciaData, function ($row) use ($selectedMunicipio) {
            return $row['Municipio'] == $selectedMunicipio;
        });
        $selectedCalle = array_unique(array_column($municipioData, 'Calle'))[$_POST['calleIndex']];
        $calleData = array_filter($municipioData, function ($row) use ($selectedCalle) {
            return $row['Calle'] == $selectedCalle;
        });
        echo wp_send_json(array_unique(array_column($calleData, 'NUMERO')));
    }

    public function loadData() {
        $data = [];
        $upload_dir = wp_upload_dir();
        $target_directory = $upload_dir['basedir'] . '/zuntza/';
        // Get a list of files in the directory
        $files = scandir($target_directory);

        // Remove "." and ".." entries
        $files = array_diff($files, array('.', '..'));

        // Sort the files by modification time (most recent first)
        arsort($files);

        // Get the most recent file
        $most_recent_file = reset($files);
        // Check if a file was found
        if ($most_recent_file) {
            $csv_file_path = $target_directory . $most_recent_file;
            foreach ($this->get_csv_data($csv_file_path) as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            // Handle the case where no files were found
            // You can display an error message or handle it as needed
            return false;
        }
    }
    public function get_csv_data($file) {
        $csvFile = new SplFileObject($file);
        $headers = $csvFile->fgetcsv();
        while (!$csvFile->eof()) {
            $row = $csvFile->fgetcsv();
            if (is_array($row)) {
                yield array_combine($headers, $row);
            }
        }
    }

    public function zuntza_form(){
        /* error_log("Rendering zuntza_form shortcode");  // Add this line
        echo "Test output";  // Add this line */
        ob_start();
        echo '<link 
        type="text/css" 
        href="'.$this->plugin_url.'dist/css/zuntza.min.css" 
        media="all" 
        rel="stylesheet" />';
        require_once($this->plugin_path."templates/zuntza-form.php");
        echo '<script src="'.$this->plugin_url.'dist/js/zuntza.min.js"></script>';
        return ob_get_clean();
    }

    
}
