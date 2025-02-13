<?php
if (!defined('ABSPATH')) {
    exit;
}

// Manejar la solicitud POST
function mi_plugin_guardar_opciones() {
    // Verificar nonce
    if (!isset($_POST['mi_plugin_nonce']) || !wp_verify_nonce($_POST['mi_plugin_nonce'], 'guardar_mi_plugin_opciones_nonce')) {
        wp_die('Error de seguridad');
    }

    // Verificar permisos del usuario
   /* if (!current_user_can('manage_options')) {
        wp_die('No tienes permisos suficientes');
    }*/

    // Procesar los datos del formulario
    $opciones = [
        'api_primary_key' => sanitize_text_field($_POST['api_primary_key']),
        'api_backup_key' => sanitize_text_field($_POST['api_backup_key']),
        'notification_email' => sanitize_email($_POST['notification_email']),
        'automatic_check' => isset($_POST['automatic_check']) ? 1 : 0,
        'site_activity_description' => sanitize_textarea_field($_POST['site_activity_description']),
    ];

    update_option('ia_manager_options', $opciones);

     //Redirigir con mensaje de éxito
    /*wp_redirect(admin_url('admin.php?page=mi-plugin&mensaje=guardado'));
    exit;*/

    wp_redirect(home_url('/gracias/'));
    exit;



    //wp_redirect(home_url());
    //exit;

}
add_action('admin_post_guardar_mi_plugin_opciones', 'mi_plugin_guardar_opciones');
?>