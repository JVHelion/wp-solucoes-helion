<?php

class Cadastra_Usuario {
    public static function insere_nas_tabelas($NOME_COMPL, $EMAIL, $SENHA) {
        $NOME_COMPL_DIVIDIDO = explode(' ', $NOME_COMPL);
        $NOME = $NOME_COMPL_DIVIDIDO[0];
        $SOBRENOME = end($NOME_COMPL_DIVIDIDO);

        global $wpdb;

        /**
         * Verifica a Existeência de um usuário com mesmo nome
         */
        
        $wpdb->insert(
            $wpdb->users, 
            array(
                'user_login' => $NOME_COMPL, 
                'user_pass' => wp_hash_password($SENHA), 
                'user_nicename' => $NOME_COMPL, 
                'user_email' => $EMAIL, 
                'user_url' => '', 
                'user_registered' => current_time('mysql'), 
                'user_activation_key' => '', 
                'user_status' => 0, 
                'display_name' => $NOME_COMPL
            ), 
            array('%s','%s','%s','%s','%s','%s','%s','%d','%s'));
        return 'Usuário de ID: ' . $wpdb->insert_id . ' criado com sucesso!';
    }
} 
?>