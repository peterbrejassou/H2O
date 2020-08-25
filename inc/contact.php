<?php
define('WPGREEN_EMAIL_TO', get_option( 'admin_email') );
define('WPGREEN_EMAIL_FROM', __('no-reply@', 'wpgreen') . str_replace('www.', '', $_SERVER['SERVER_NAME'] ) );
define('WPGREEN_SUBJECT', __('Nouveau message depuis votre site web','wpgreen') );

add_action( 'init', 'contact_custom_post_type');
function contact_custom_post_type() {
	register_post_type( 'wpgreen_contact', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		array('labels' 			=> array(
				'name' 				=> __('Contacts', 'wpgreen'), /* This is the Title of the Group */
				'singular_name' 	=> __('Contact', 'wpgreen'), /* This is the individual type */
			), /* end of arrays */
			'menu_position' 	=> 18, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' 		=> 'dashicons-email-alt', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'hierarchical' 		=> false,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => false,
			'supports' 			=> array( 'title', 'editor')
	 	) /* end of options */
	);
}


/*
* traitement du post du form de Contact
* enregistrement des values dans le custom post type
*/
add_action( 'wp_ajax_formContact', 'wpgreen_formContact' );
add_action( 'wp_ajax_nopriv_formContact', 'wpgreen_formContact' );
function wpgreen_formContact(){
	if (wp_verify_nonce($_POST['nonceformContact'], 'nonceformContact')) {

		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lce1FIUAAAAAC2kWX5qMMyHpfdW-IyRX927KGji&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$obj = json_decode($response);
		if($obj->success == false){//si pb captcha
			die();
		}

		global $wpdb;

		$upload_file_text = "";
		$attachments = array();
		if(isset($_FILES['file'])){
			$maintenant = date("d-m-Y_H:i:s");
			$upload_dir   = wp_upload_dir();
			$uploaddirimg = $upload_dir['basedir'].'/img-form/';
			mkdir($uploaddirimg, 0755);
			$uploadfile = $uploaddirimg . $maintenant . '-'.basename($_FILES['file']['name']);
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				array_push($attachments, $uploadfile);
				$upload_file_text = "Fichier : ".$upload_dir['baseurl'].'/img-form/' . $maintenant . '-'.basename($_FILES['file']['name']);
			}
		}

		$subject = WPGREEN_SUBJECT;
		$body = 'Nom : '.sanitize_text_field($_POST['name'])."\r\n";
		$body .= 'Prénom : '.sanitize_text_field($_POST['firstname'])."\r\n";
		$body .= 'email : '.sanitize_text_field($_POST['email'])."\r\n";
		$body .= 'Téléphone : '.sanitize_text_field($_POST['phone'])."\r\n";
		$body .= 'Commentaire : '.sanitize_textarea_field($_POST['comment'])."\r\n";
		$body .= $upload_file_text;
		$headers[] = 'From: '.get_bloginfo('name').' <'. WPGREEN_EMAIL_FROM .'>';
		wp_mail( WPGREEN_EMAIL_TO, $subject, $body, $headers, $attachments);
    $post['post_type']   = 'wpgreen_contact';
    $post['post_status'] = 'publish';
		$post['post_title'] = sanitize_text_field($_POST['firstname']).' '.sanitize_text_field($_POST['name']);
		$post['post_content'] = $body;
		wp_insert_post( $post, true );

		$body = __('Bonjour,
Nous avons bien reçu votre demande d’informations.
Elle sera traitée rapidement
Bien cordialement','wpgreen');
		$headers[] = 'From: '.get_bloginfo('name').' <'. WPGREEN_EMAIL_FROM .'>';
		wp_mail( sanitize_text_field($_POST['email']), __("Votre demande d'informations",'wpreen'), $body, $headers);
	}
	die();
}


// wp_dashboard_setup is the action hook
add_action('wp_dashboard_setup', 'cl_dashboard');
function cl_dashboard() {
    wp_add_dashboard_widget('cl_dashboard_widget', 'Export CSV','cl_custom_dashboard_message');
}
function cl_custom_dashboard_message(){
	?>
	<ul>
	<li><a href="?report=wpgreen_csvUser" class="button">USER</a></li>
	<li><a href="?report=wpgreen_csvDesign" class="button">Design</a></li>
	<li><a href="?report=wpgreen_CSVDesignAbandon" class="button">Design abandonné</a></li>
	<li><a href="?report=wpgreen_CSVOrders" class="button">Orders</a></li>
	<li><a href="?report=wpgreen_CSVOrderAbandon" class="button">Order Abandon</a></li>
	<li><a href="?report=wpgreen_CSVAsk" class="button">Ask Expert</a></li>
	<li><a href="?report=wpgreen_CSVTechnicalDocumentation" class="button">Download technical documentation</a></li>
	
	</ul>
	<?php
}
class wpgreen_CSVExport
{
	/**
	* Constructor
	*/
	public function __construct()
    {
        if(isset($_GET['page']) && $_GET['page'] == 'wpgreen_download_report' && isset($_GET['page']) && $_GET['report'] == 'wpgreen_contact')
        {
        	$this->wpgreen_export();
        }
		else if(isset($_GET['page']) && $_GET['page'] == 'wpgreen_download_report'){
        	exit;
        }
    }
	public function wpgreen_export(){
		global $wpdb;
        $csv_fields=array();
        $csv_fields[] = 'Title';
		$csv_fields[] = 'Content';
        $output_filename = "contact_".date("Y-m-d H:i:s").'.csv';
        $output_handle = @fopen( 'php://output', 'w' );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Content-Description: File Transfer' );
        header( 'Content-type: text/csv' );
        header( 'Content-Disposition: attachment; filename=' . $output_filename );
        header( 'Expires: 0' );
        header( 'Pragma: public' );
        // Insert header row
        fputcsv( $output_handle, $csv_fields,";" );
		global $post;
		$args = array( 'posts_per_page' => -1, 'post_type' => 'wpgreen_contact' );
		$myposts = get_posts( $args );
		foreach ( $myposts as $post ) : setup_postdata( $post );
			$tab_data = array( get_the_title(), str_replace('
',' - ',$post->post_content) );
			fputcsv( $output_handle, $tab_data,";");
		endforeach;
		wp_reset_postdata();
        fclose( $output_handle );
		exit();
	}
}
// Instantiate a singleton of this plugin
new wpgreen_CSVExport();
