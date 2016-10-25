<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_menu', 'clp_reg_menu' );

function clp_reg_menu(){
	add_options_page( __('Customize Login Page', 'CustomizeLoginPage'), __('Customize Login Page', 'CustomizeLoginPage'), 'administrator', 'customize-login-page', 'clp_CustomizeLogin'); 
}

//////////////////////////
# Load plugin text domain
add_action( 'init', 'clp_plugin_textdomain' );
# Text domain for translations
function clp_plugin_textdomain() {
    $domain = 'CustomizeLoginPage';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
//////////////////////////

function clp_CustomizeLogin(){ 
	if(isset($_POST['height']) ){
		//print_r($_POST);
                $data['image_url'] = sanitize_text_field( $_POST['image_url'] );
                $data['height'] = sanitize_text_field( $_POST['height'] );
                $data['width'] = sanitize_text_field( $_POST['width'] );
                $data['backgroundcolor'] = sanitize_text_field( $_POST['backgroundcolor'] );

                update_option('customize-login-page', $data);		
		echo '<br /> <br /> <h2 style="
		  color: green;
		  background-color: white;
		  height: 15px;
		  width: 95%;
   		padding: 20px;">'.__('Saved Successfully', 'CustomizeLoginPage').'</h2>';
	}else{
		$data =  get_option('customize-login-page'); 
		//print_r($data);
	}
		$image_url = (isset($data['image_url']))? esc_html($data['image_url']) : '';
		$height = (isset($data['height']))? esc_html($data['height']) : '100px';
		$width = (isset($data['width']))? esc_html($data['width']) : '160px';
		$backgroundcolor = (isset($data['backgroundcolor']))? esc_html($data['backgroundcolor']) : '#ffffff';
	?>
        <div class="wrap">
            <?php screen_icon('edit-pages'); ?>
			<h2><?php _e('Customize Login Page', 'CustomizeLoginPage') ?></h2>
            <h4><?php _e('Customize your Login Page with your Logo', 'CustomizeLoginPage') ?></h4>
            <form method="post" action="">
				<?php settings_fields( 'disable-settings-group' ); ?>
            	<?php do_settings_sections( 'disable-settings-group' ); ?>
			<br/>
			<table>	
			<tr>
				<td><label> <?php _e('Upload Logo', 'CustomizeLoginPage') ?> </label></td>
				<td>
					<input id="image_url" type="text" size="30" name="image_url" value="<?php echo $image_url ?>" /><br/>
					<input id="image_url_button" class="button" type="button" value="Upload Image" />	
				</td>
				<td>
					<img id="uploadPreview" src="<?php echo $image_url ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" title="<?php echo get_bloginfo( 'name' ); ?>" > 
				</td>
			</tr>
			<tr>
				<td><label> <?php _e('Height', 'CustomizeLoginPage') ?> </label></td>
				<td><input id="height" type="text" size="30" name="height" value="<?php echo $height ?>" maxlength="5" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Width', 'CustomizeLoginPage') ?> </label></td>
				<td><input id="width" type="text" size="30" name="width" value="<?php echo $width ?>" maxlength="5" /> </td>
				<td> </td>
			</tr>
			<tr>
				<td><label> <?php _e('Background Color', 'CustomizeLoginPage') ?> </label</td>
				<td><input id="backgroundcolor" type="text" size="30" name="backgroundcolor" value="<?php echo $backgroundcolor ?>" maxlength="7" /> </td>
			<tr>
				<td> </td>
				<td> <a href="<?php echo wp_login_url(); ?>" target="_blank"> <?php _e('Preview Login Page', 'CustomizeLoginPage') ?> <a> </td>
			</tr>
			</table>
			<br>
			
                <?php submit_button(); ?>
			
            </form>
        </div>	
		
<script type="text/javascript">
    jQuery( document ).ready(function() {
		jQuery(document).on('change', '#height', function() {
			var height = jQuery('#height').val();
			jQuery('#uploadPreview').attr("height", height);
		});
		jQuery(document).on('change', '#width', function() {
			var width = jQuery('#width').val();
			jQuery('#uploadPreview').attr("width", width);
		});
    });
</script>		
<script>
 var image_custom_uploader;
 jQuery('#image_url_button').click(function(e) {
 e.preventDefault();

 //If the uploader object has already been created, reopen the dialog
 if (image_custom_uploader) {
 image_custom_uploader.open();
 return;
 }

 //Extend the wp.media object
 image_custom_uploader = wp.media.frames.file_frame = wp.media({
 title: 'Choose Image',
 button: {
 text: 'Choose Image'
 },
 multiple: false
 });

 //When a file is selected, grab the URL and set it as the text field's value
 image_custom_uploader.on('select', function() {
 attachment = image_custom_uploader.state().get('selection').first().toJSON();
 var url = '';
 url = attachment['url'];
 var height = attachment['height'];
 var width = attachment['width'];
 jQuery('#image_url').val(url);
 jQuery('#uploadPreview').attr("src", url);
  jQuery('#uploadPreview').attr("height", height+"px");
	jQuery('#height').attr("value", height+"px");
  jQuery('#uploadPreview').attr("width", width+"px");
	jQuery('#width').attr("value", width+"px");
 });

 //Open the uploader dialog
 image_custom_uploader.open();
 });
</script>


<?php
}

///////////////////// Customize Login Page  /////////////////////
function clp_loginLogo() {

	$data =  get_option('customize-login-page'); 
		
		$image_url = (isset($data['image_url']))? esc_html($data['image_url']) : '';
		$height = (isset($data['height']))? esc_html($data['height']) : '100px';
		$width = (isset($data['width']))? esc_html($data['width']) : '160px';
		$backgroundcolor = (isset($data['backgroundcolor']))? esc_html($data['backgroundcolor']) : '#ffffff';

    $logoUrl = ($image_url)? $image_url : get_template_directory_uri().'/img/logo.png' ;
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( 'style.css', __FILE__ ).'" />';
    echo '<style> .login h1 a { background-image: url('.$logoUrl.');
		width: '.$width.';
		height: '.$height.';
		display: block;
		margin-right: auto;
		margin-left: auto;
		background-size: cover;
		background-position: center;  } 
		body.login {
			background: ' . $backgroundcolor . ';
		}
		</style>' ;
}
 
add_action( 'login_head', 'clp_loginLogo' );
///
function clp_loginTitle( $title ) {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'clp_loginTitle' );
/////
function clp_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'clp_login_logo_url' );

///////////////
function clp_load_wp_media_files() {
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'clp_load_wp_media_files' );

?>