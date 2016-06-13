<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Gettext\Translations;

class WPTXU_Translation
{

	private $text_domain_path;
	private $po_file_path;
	private $mo_file_path;
	private $filename;

	public function __construct( $project_id, $tx_infos, $project_type, $text_domain, $lang_code, $content ) {

		$this->project_id = $project_id;
		$this->project =  $tx_infos;
		$this->project_type = $project_type;
		$this->text_domain = $text_domain;
		$this->lang_code = $lang_code;
		$this->content = $content;

		if( get_post_meta( $this->project_id, 'wptxu_mo_filename', true ) ) {
			$this->filename = get_post_meta( $this->project_id, 'wptxu_mo_filename', true );
		} else {
			$this->filename = $text_domain;
		}

		if( $this->project_type == 'plugins') {

			$this->text_domain_path = WPTXU_CONTENT_PATH . '/' . $this->project_type . '/' . $this->text_domain . '/' . $this->lang_code . '/';
			$this->po_file_path = $this->text_domain_path . $this->filename . '-' . $this->lang_code . '.po';
			$this->mo_file_path = $this->text_domain_path . $this->filename . '-' . $this->lang_code . '.mo';

		} else {

			$this->text_domain_path = WPTXU_CONTENT_PATH . '/' . $this->project_type . '/' . $this->text_domain . '/' . $this->lang_code . '/';
			$this->po_file_path = $this->text_domain_path . $this->lang_code . '.po';
			$this->mo_file_path = $this->text_domain_path . $this->lang_code . '.mo';

		}

	}


	public function make_translation(){

		if ( ! is_dir( $this->text_domain_path ) ) {
			wptxu_mkdir_p( $this->text_domain_path );
			echo '<li class="wptxu-success">' . __( 'Translation folder created.', 'wpt-tx-updater' ) . '</li>';
	    }

    	$this->_save_po_file();
    	$this->_create_mo_file();
    	$this->_create_readme_file();
    	$this->_is_up_to_date();

	}

	private function _save_po_file() {

		$po_file = wptxu_put_content( $this->po_file_path,  $this->content );
		echo '<li class="wptxu-success">'. __( 'Import po file on local filesystem.', 'wpt-tx-updater' ) .'</li>';

	}

	private function _create_mo_file() {

		$file = Translations::fromPoFile( $this->po_file_path );
	    $file->toMoFile( $this->mo_file_path );
	    echo '<li class="wptxu-success">'. __( 'Create mo file on local filesystem.', 'wpt-tx-updater' ) .'</li>';
	}

	private function _create_readme_file() {

		$txt = '=== '. $this->text_domain .' ===' . "\r\n";
		$txt .= 'Locale : '. $this->lang_code . "\r\n";
		$txt .= 'Last update : '. $this->project->last_update . "\r\n";
		$txt .= 'Last commiter : '. $this->project->last_commiter . "\r\n";

		$readme_content = wptxu_put_content( $this->text_domain_path . 'readme.txt', $txt );
		echo '<li class="wptxu-success">'. __( 'Create readme file on local filesystem.', 'wpt-tx-updater' ) .'</li>';
	}

	private function _is_up_to_date() {

		if ( is_file( $this->text_domain_path . 'readme.txt' ) ) {

			$readme = new WordPress_Readme_Parser();
			$readme = $readme->parse_readme( $this->text_domain_path . 'readme.txt' );

			if ( strtotime( $this->project->last_update ) == strtotime( $readme['last_update'] ) ) {

				echo '<li>' . __( 'Translation is up to date!', 'wpt-tx-updater' ) . '</li>';
				return true;

			} else {

				echo '<li class="wpts-warning">' . __( 'Translation update available!', 'wpt-tx-updater' ) . ' - ' . __( 'Locale translation', 'wpt-tx-updater' ) .' : ' . $readme['last_update'] .  ' - ' . __( 'Transifex translation', 'wpt-tx-updater' ) .' : ' . $this->project->last_update .  ' </li>';
				return false;

			}

		} else {

			return false;

		}

	}

}
