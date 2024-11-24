<?php

class Cadastra_Usuario {
    public static function insere_nas_tabelas($NOME_COMPL, $EMAIL, $SENHA): string {
        $NOME_COMPL_DIVIDIDO = explode(separator: ' ', string: $NOME_COMPL);
        $NOME = $NOME_COMPL_DIVIDIDO[0];
        $SOBRENOME = end(array: $NOME_COMPL_DIVIDIDO);

        global $wpdb;

        /**
         * Verifica um usuário com mesmo nome
         */

        $usuario_ja_existe =$wpdb->get_var($wpdb->prepare("SELECT COUNT(user_login) FROM $wpdb->users WHERE user_login = %s", $NOME_COMPL));

        /**
         * Verifica um email já existente
         */
        $email_ja_existe = $wpdb->get_var($wpdb->prepare("SELECT COUNT(user_email) FROM $wpdb->users WHERE user_email = %s", $EMAIL));

        $ID_DO_PROXIMO_USUARIO = $wpdb->get_var("SELECT MAX(ID) + 1 FROM $wpdb->users");
        if ( $usuario_ja_existe > 1) {
            $NOME_COMPL = $NOME_COMPL . $ID_DO_PROXIMO_USUARIO ;
        }

        if ($email_ja_existe > 1) {
            $EMAIL_DIVIDIDO = explode(separator: "@", string: $EMAIL);
            $EMAIL_ANTES_DO_ARROBA = $EMAIL_DIVIDIDO[0];
            $EMAIL_DEPOIS_DO_ARROBA = $EMAIL_DIVIDIDO[1];  
            $EMAIL = $EMAIL_ANTES_DO_ARROBA . "+" . $ID_DO_PROXIMO_USUARIO . "@" . $EMAIL_DEPOIS_DO_ARROBA ;
        }   
        
        $wpdb->insert(
            $wpdb->users, 
            array(
                'user_login' => $NOME_COMPL, 
                'user_pass' => wp_hash_password($SENHA), 
                'user_nicename' => $NOME . ' ' . $SOBRENOME, 
                'user_email' => $EMAIL, 
                'user_url' => '', 
                'user_registered' => current_time('mysql'), 
                'user_activation_key' => '', 
                'user_status' => 0, 
                'display_name' => $NOME . ' ' . $SOBRENOME
            ), 
            array('%s','%s','%s','%s','%s','%s','%s','%d','%s'));
        return 'Usuário de ID: ' . $wpdb->insert_id . ' criado com sucesso!';
    }
} 
?>