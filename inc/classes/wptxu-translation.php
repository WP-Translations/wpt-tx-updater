<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Gettext\Translations;

class WPTXU_Translation
{
	
	private $text_domain_path;
	private $po_file_path;
	private $mo_file_path;

	public function __construct( $project, $project_type, $text_domain, $lang_code, $content ) {

		$this->project = $project;
		$this->project_type = $project_type;
		$this->text_domain = $text_domain;
		$this->lang_code = $lang_code;
		$this->content = $content;
		$this->text_domain_path = WPTXU_CONTENT_PATH . '/' . $this->project_type . '/' . $this->text_domain . '/' . $this->lang_code . '/';
		$this->po_file_path = $this->text_domain_path . $this->text_domain . '-' . $this->lang_code . '.po';
		$this->mo_file_path = $this->text_domain_path . $this->text_domain . '-' . $this->lang_code . '.mo';

	}


	public function make_translation(){

		if ( ! is_dir( $this->text_domain_path ) ) {
			wptxu_mkdir_p( $this->text_domain_path );
			echo '<li class="wptxu-success">' . __( 'Translation folder created.', 'wp-translations-server' ) . '</li>';
	    }
	    
	    if ( false === $this->_is_up_to_date() ) {

	    	$this->_save_po_file();
	    	$this->_create_mo_file();
	    	$this->_create_readme_file();
	    	$this->_is_up_to_date();

		}
 
	}

	private function _save_po_file() {

		$po_file = wptxu_put_content( $this->po_file_path,  $this->content );
		echo '<li class="wptxu-success">'. __( 'Save po file on local filesystem.', 'wp-translations-server' ) .'</li>';		
		
	}

	private function _create_mo_file() {

		$file = Translations::fromPoFile( $this->po_file_path );
	    $file->toMoFile( $this->mo_file_path );
	    echo '<li class="wptxu-success">'. __( 'Create and save mo file on local filesystem.', 'wp-translations-server' ) .'</li>';
	}

	private function _create_readme_file() {
		
		$txt = '=== '. $this->text_domain .' ===' . "\r\n";
		$txt .= 'Locale : '. $this->lang_code . "\r\n";
		$txt .= 'Last update : '. $this->project->last_update . "\r\n";
		$txt .= 'Last commiter : '. $this->project->last_commiter . "\r\n";

		$readme_content = wptxu_put_content( $this->text_domain_path . 'readme.txt', $txt );
		echo '<li class="wptxu-success">'. __( 'Create and save readme file on local filesystem.', 'wp-translations-server' ) .'</li>';
	}

	private function _is_up_to_date() {

		if ( is_file( $this->text_domain_path . 'readme.txt' ) ) {

			$readme = new WordPress_Readme_Parser();
			$readme = $readme->parse_readme( $this->text_domain_path . 'readme.txt' );

			if ( strtotime( $this->project->last_update ) == strtotime( $readme['last_update'] ) ) {

				echo '<li>' . __( 'Translation is up to date !', 'wpt-tx-updater' ) . ' - ' .  __('Last update', 'wpt-tx-updater') . '&nbsp;:&nbsp;' . $readme['last_update'] . '</li>';
				return true;

			} else {

				echo '<li class="wpts-warning">' . __( 'Translation update available !', 'wpt-tx-updater' ) . ' - ' . __( 'Locale translation', 'wpt-tx-updater' ) .' : ' . $readme['last_update'] .  ' - ' . __( 'Transifex translation', 'wpt-tx-updater' ) .' : ' . $this->project->last_update .  ' </li>';
				return false;

			}

		} else {

			return false;

		}
		
	}

}
