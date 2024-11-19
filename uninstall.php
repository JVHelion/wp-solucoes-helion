<?php

if ( ! defined( constant_name: 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// if uninstall.php is not called by WordPress, die
if ( ! defined( constant_name: 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

class sbrnm_deleta_tabela_de_config {
    public static function deletar_tabela(): void {
        global $wpdb;

        $wp_sbrnm_users = $wpdb->prefix .'sbrnm_users';
        $wpdb->query("DROP TABLE IF EXISTS $wp_sbrnm_users");
    }
}

register_uninstall_hook(file: __FILE__, callback: array("sbrnm_deleta_tabela_de_config", "deletar_tabela"));
?>