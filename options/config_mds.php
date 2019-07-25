<?php
// create custom plugin settings menu
add_action('admin_menu', 'mds_create_menu');

function mds_create_menu() {

add_submenu_page( 'options-general.php', 'Konfiguruj MDS', 'Konfiguruj MDS',
    'edit_pages', 'mds', 'config_mds_page');
	add_action( 'admin_init', 'register_mds_options_settings' );
}

function register_mds_options_settings() {
	register_setting( 'mds-options-settings-group', 'login' );
        register_setting( 'mds-options-settings-group', 'password' );
}

function config_mds_page() {
?>
<div class="wrap">
<h1>Konfiguracja MDS-a</h1>
<br/>
<form method="post" action="options.php">
    <?php settings_fields( 'mds-options-settings-group' ); ?>
    <?php do_settings_sections( 'mds-options-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Login / Pin</th>
        <td><input type="text" name="login" value="<?php echo esc_attr( get_option('login') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Hasło</th>
        <td><input type="text" name="password" value="<?php echo esc_attr( get_option('password') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
<hr/><br/>
<form method="post" action="import_data">
<label><input type="checkbox" name="regions" id="regions" checked />Importuj regiony</label><br/>
<label><input type="checkbox" name="options" id="options" checked />Importuj opcje</label><br/>
<label><input type="checkbox" name="tourop" id="tourop" checked />Importuj Tour operatorów</label><br/>
<label><input type="checkbox" name="service" id="service" checked />Importuj wyżywienie</label><br/>
<label><input type="checkbox" name="codes" id="codes" checked />Importuj kody odpowiedzi z MDS</label><br/>
<label><input type="checkbox" name="currencies" id="currencies" checked />Importuj przelicznik walut</label>
<?php submit_button('Importuj'); ?>
</form>
<?php }