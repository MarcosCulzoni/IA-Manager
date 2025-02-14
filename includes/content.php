<?php
if (!defined('ABSPATH')) {
    exit;
}

// Obtener opciones actuales
$opciones_actuales = recuperar_opciones();

/*

//Obtener la URL de la página de configuración
$pagina_id = get_option('IA_Manager_Config_ID');
$pagina_url = get_permalink($pagina_id);
if ($pagina_url) {
    wp_redirect($pagina_url);
    exit;
} else {
    echo 'No se pudo encontrar la página de configuración.';
}

*/



function recuperar_opciones()
{
    // Recupera la opción 'ia_manager_options' desde la base de datos.
    $IA_manager_option = get_option('ia_manager_options');

    // Si no existe, define valores por defecto.
    if (false === $IA_manager_option) {
        $IA_manager_option = array(
            'api_primary_key'           => 'TU_CLAVE_API_PRINCIPAL',
            'api_backup_key'            => 'TU_CLAVE_API_RESERVA',
            'notification_email'        => 'notificaciones@tusitio.com',
            'automatic_check'           =>  false, //Se define como un valor booleano
            'site_activity_description' => 'Descripción breve de la actividad principal del sitio.'
        );
    }

    return $IA_manager_option;
}
?>

<form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="guardar_mi_plugin_opciones">
    <?php wp_nonce_field('guardar_mi_plugin_opciones_nonce', 'mi_plugin_nonce'); ?>

    <label for="api_primary_key">API Primary Key:</label>
    <input type="text" id="api_primary_key" name="api_primary_key" value="<?php echo esc_attr($opciones_actuales['api_primary_key']); ?>" />

    <label for="api_backup_key">API Backup Key:</label>
    <input type="text" id="api_backup_key" name="api_backup_key" value="<?php echo esc_attr($opciones_actuales['api_backup_key']); ?>" />

    <label for="notification_email">Notification Email:</label>
    <input type="email" id="notification_email" name="notification_email" value="<?php echo esc_attr($opciones_actuales['notification_email']); ?>" />

    <label for="automatic_check">Automatic Check:</label>
    <input type="checkbox" id="automatic_check" name="automatic_check" <?php checked($opciones_actuales['automatic_check'], true); ?> />

    <label for="site_activity_description">Site Activity Description:</label>
    <textarea id="site_activity_description" name="site_activity_description"><?php echo esc_textarea($opciones_actuales['site_activity_description']); ?></textarea>

    <button type="submit">Guardar Opciones</button>
</form>


<?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
    <!-- Modal HTML -->
    <div id="mensaje-exito-modal" style="display: none;">
        <div class="modal-contenido">
            <h2>¡Opciones guardadas con éxito!</h2>
            <p>Los cambios se han guardado correctamente.</p>
            <button id="cerrar-modal">Cerrar</button>
        </div>
    </div>

    <!-- JavaScript para manejar el modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Detectar si el modal debe mostrarse
            var modal = document.getElementById('mensaje-exito-modal');
            if (modal) {
                modal.style.display = 'flex'; // Mostrar el modal

                // Agregar evento para cerrar el modal
                var botonCerrar = document.getElementById('cerrar-modal');
                if (botonCerrar) {
                    botonCerrar.addEventListener('click', function () {
                        modal.style.display = 'none';
                        // Opcionalmente, elimina el parámetro de la URL para no volver a mostrar el modal
                        var url = new URL(window.location.href);
                        url.searchParams.delete('status');
                        window.history.replaceState(null, '', url);
                    });
                }
            }
        });
    </script>
<?php endif; ?>


