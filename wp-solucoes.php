<?php
/*
 * Plugin Name: WP Soluções
 * Description: Complementos para e-commerce, fazer o que se wp me deixou na mão ¯\_(ツ)_/¯
 * Version: 0.0.1
 * Requires at least: 6.7
 * Requires at least: 8.1
 * Author: JVHelion
 * 
 */

if (! defined(constant_name: 'ABSPATH')) {
    exit; // Exit if accessed directly
}

class sbrnm_cria_tabela_de_config
{
    public static function criar_tabela(): void
    {
        global $wpdb;

        $wp_sbrnm_users = $wpdb->prefix . 'sbrnm_users';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $wp_sbrnm_users (ID_USER INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (ID_USER), user_login varchar(60) NOT NULL) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

register_activation_hook(file: __FILE__, callback: array("sbrnm_cria_tabela_de_config", "criar_tabela"));
