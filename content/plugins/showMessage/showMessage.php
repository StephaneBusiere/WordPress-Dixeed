<?php
/**
 * Plugin Name: showMessage
 * Description: Un plugin qui active/désactive l'affichage d'un message sur le dashboard client
 * Version: 1.0
 * Author: Stéphane Busiere
 */
// Register Custom Post Type

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

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
        );
}
}
}
add_action('add_meta_boxes', 'my_meta_init');

function wporg_custom_box_html($post)
{
    $val = get_post_meta($post->ID,'_ma_valeur',true);
    
    
    echo'<label for="wporg_field">Entrez votre message</label>';
    echo '<input class="inputMetabox" id="mon_champ" type="text" name="mon_champ" value="'.$val.'"/>';
    
    
}
add_action('save_post','save_metaboxes');
function save_metaboxes($post_ID){
    if(isset($_POST['mon_champ'])){
        update_post_meta($post_ID,'_ma_valeur', esc_html($_POST['mon_champ']));
      }
}
class OAgencySettings {
	private $oagency_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'oagency_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'oagency_settings_page_init' ) );
	}

	public function oagency_settings_add_plugin_page() {
		add_menu_page(
			'ShowMessage Settings', // page_title
			'ShowMessage Settings', // menu_title
			'manage_options', // capability
			'showmessage-settings', // menu_slug
			array( $this, 'oagency_settings_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			100 // position
		);
	}

	public function oagency_settings_create_admin_page() {
		$this->oagency_settings_options = get_option( 'oagency_settings_option_name' ); ?>

		<div class="wrap">
			<h2>oAgency Settings</h2>
			<p>Page de reglages</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'oagency_settings_option_group' );
					do_settings_sections( 'oagency-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function oagency_settings_page_init() {
		register_setting(
			'oagency_settings_option_group', // option_group
			'oagency_settings_option_name', // option_name
			array( $this, 'oagency_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'oagency_settings_setting_section', // id
			'Settings', // title
			array( $this, 'oagency_settings_section_info' ), // callback
			'oagency-settings-admin' // page
		);

		add_settings_field(
			'afficher_twitter_0', // id
			'Afficher Twitter', // title
			array( $this, 'afficher_twitter_0_callback' ), // callback
			'oagency-settings-admin', // page
			'oagency_settings_setting_section' // section
		);

		add_settings_field(
			'compte_twitter_1', // id
			'Compte Twitter', // title
			array( $this, 'compte_twitter_1_callback' ), // callback
			'oagency-settings-admin', // page
			'oagency_settings_setting_section' // section
		);
	}

	public function oagency_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['afficher_twitter_0'] ) ) {
			$sanitary_values['afficher_twitter_0'] = $input['afficher_twitter_0'];
		}

		if ( isset( $input['compte_twitter_1'] ) ) {
			$sanitary_values['compte_twitter_1'] = sanitize_text_field( $input['compte_twitter_1'] );
		}

		return $sanitary_values;
	}

	public function oagency_settings_section_info() {

	}

	public function afficher_twitter_0_callback() {
		printf(
			'<input type="checkbox" name="oagency_settings_option_name[afficher_twitter_0]" id="afficher_twitter_0" value="afficher_twitter_0" %s> <label for="afficher_twitter_0">Afficher le compte twitter</label>',
			( isset( $this->oagency_settings_options['afficher_twitter_0'] ) && $this->oagency_settings_options['afficher_twitter_0'] === 'afficher_twitter_0' ) ? 'checked' : ''
		);
	}

	public function compte_twitter_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="oagency_settings_option_name[compte_twitter_1]" id="compte_twitter_1" value="%s">',
			isset( $this->oagency_settings_options['compte_twitter_1'] ) ? esc_attr( $this->oagency_settings_options['compte_twitter_1']) : ''
		);
	}

}
if ( is_admin() )
	$oagency_settings = new OAgencySettings();

?>
