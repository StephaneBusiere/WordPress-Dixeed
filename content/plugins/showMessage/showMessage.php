<?php
/**
 * Plugin Name: showMessage
 * Description: Un plugin qui active/désactive l'affichage d'un message sur le dashboard client
 * Version: 1.0
 * Author: Stéphane Busiere
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//create metabox in "Mon compte" page setings
function my_meta_init()
{
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
// checks for post/page ID
if ($post_id == '9')
		{
    $screens = ['page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'wporg_box_id',           // Unique ID
            'Ajouter un text',  // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );}
		}
}

add_action('add_meta_boxes', 'my_meta_init');
//create metabox field content
function wporg_custom_box_html($post)
{
    $val = get_post_meta($post->ID,'_ma_valeur',true);
    
    
    echo'<label for="wporg_field">Entrez votre message</label>';
    echo '<input class="inputMetabox" id="mon_champ" type="text" name="mon_champ" value="'.$val.'"/>';
    
    
}
add_action('save_post','save_metaboxes');
//Save metabox 
function save_metaboxes($post_ID){
    if(isset($_POST['mon_champ'])){
        update_post_meta($post_ID,'_ma_valeur', esc_html($_POST['mon_champ']));
      }
}

//Create show message plugin settings to write and show a message in dashboard page
class ShowMessageSettings {
	private $showmessage_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'showmessage_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'showmessage_settings_page_init' ) );
	}

	public function showmessage_settings_add_plugin_page() {
		add_menu_page(
			'ShowMessage Réglages', // page_title
			'ShowMessage Réglages', // menu_title
			'manage_options', // capability
			'showmessage-reglages', // menu_slug
			array( $this, 'showmessage_settings_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			100 // position
		);
	}

	public function showmessage_settings_create_admin_page() {
		$this->showmessage_settings_options = get_option( 'showmessage_settings_option_name' ); ?>

		<div class="wrap">
			<h2>showmessage Réglages</h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'showmessage_settings_option_group' );
					do_settings_sections( 'showmessage-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function showmessage_settings_page_init() {
		register_setting(
			'showmessage_settings_option_group', // option_group
			'showmessage_settings_option_name', // option_name
			array( $this, 'showmessage_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'showmessage_settings_setting_section', // id
			'Réglages', // title
			array( $this, 'showmessage_settings_section_info' ), // callback
			'showmessage-settings-admin' // page
		);

		

		add_settings_field(
			'text_1', // id
			'Entrez votre text', // title
			array( $this, 'text_1_callback' ), // callback
			'showmessage-settings-admin', // page
			'showmessage_settings_setting_section' // section
		);
	}

	public function showmessage_settings_sanitize($input) {
		$sanitary_values = array();

		if ( isset( $input['text_1'] ) ) {
			$sanitary_values['text_1'] = sanitize_text_field( $input['text_1'] );
		}

		return $sanitary_values;
	}

	public function showmessage_settings_section_info() {

	}


	public function text_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="showmessage_settings_option_name[text_1]" id="text_1" value="%s">',
			isset( $this->showmessage_settings_options['text_1'] ) ? esc_attr( $this->showmessage_settings_options['text_1']) : ''
		);
	}

}
if ( is_admin() )
	$showmessage_settings = new ShowMessageSettings();

?>
