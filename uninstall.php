<?php 
/**
 * Eu configurei esse uninstall apenas para dropar a tabela wp_solucoes_users, só não vou remover outras linhas de outras tabelas, pois com certeza algo no wordpress vai explodir. Então boa sorte para os inserts feitos durante o desenvolvimento.
 */
if ( ! defined( constant_name: 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// if uninstall.php is not called by WordPress, die
if ( ! defined( constant_name: 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

class solucoes_users_deleta_tabela_de_config {
    public static function deletar_tabela(): void {
        global $wpdb;

        $wp_solucoes_users = $wpdb->prefix .'solucoes_users';
        $wpdb->query("DROP TABLE IF EXISTS $wp_solucoes_users");
    }
}

solucoes_users_deleta_tabela_de_config::deletar_tabela();
?>