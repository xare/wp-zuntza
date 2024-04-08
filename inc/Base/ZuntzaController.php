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

        $levels = ['provincia', 'municipio', 'calle', 'numero', 'final'];
        foreach( $levels as $level ) {
            add_action( 'wp_ajax_get_'.$level, [ $this, 'get_'.$level ] );
            add_action( 'wp_ajax_nopriv_get_'.$level, [ $this, 'get_'.$level ] );    
        }
    }

    
    public function get_provincia() {
        $data = $this->_loadData();
        echo wp_send_json(array_unique(array_column($data, 'Provincia')));
    }

    public function get_municipio() {
        $data = $this->_loadData();
    
        $provinciaData = $this->_columnData($data, $_POST['query'], 'Provincia');
        echo wp_send_json(array_unique(array_column($provinciaData, 'Municipio')));
    }

    public function get_calle() {
        $data = $this->_loadData();
       //$provinciaData = $this->_columnData($data, $_POST['provinciaIndex'], 'Provincia');
        $municipioData = $this->_columnData($data, $_POST['query'], 'Municipio');
        echo wp_send_json(array_unique(array_column($municipioData, 'Calle')));
    }

    public function get_numero() {
        $data = $this->_loadData();

        //$provinciaData = $this->_columnData($data, $_POST['provinciaIndex'], 'Provincia');
        //$municipioData = $this->_columnData($data, $_POST['municipioIndex'], 'Municipio');
        $calleData = $this->_columnData($data, $_POST['query'], 'Calle');

        echo wp_send_json(array_unique(array_column($calleData, 'NUMERO')));
    }

    public function get_final() {
        echo "Zuk emandako helbidean badago zuntza optikoa.";
        return;
    }

    private function _loadData() {
        $data = [];
        $upload_dir = wp_upload_dir();
        $target_directory = $upload_dir['basedir'] . '/zuntza/';
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
    
    private function _columnData($data, $postData, $column){

        // Filter out unique column data that contains the substring in $postData
        $filteredData = array_filter(array_unique(array_column($data, $column)), function($item) use ($postData) {
            return stripos($item, $postData) !== false;
        });

        // Create an array to hold the final filtered data
        $itemData = [];

        foreach ($filteredData as $selectedItem) {
            // Filter $data to only include rows that match the $selectedItem
            $partialItemData = array_filter($data, function ($row) use ($selectedItem, $column) {
                return $row[$column] == $selectedItem;
            });

            // Merge the partial data into the final data
            $itemData = array_merge($itemData, $partialItemData);
        }

        return $itemData;
    }
}
