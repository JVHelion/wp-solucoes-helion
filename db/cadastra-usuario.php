<?php
/**
 * Eu fiz essa classe cabulosa para inserir um usuário no wordpress através de ódio e raiva.
 * 
 * Eu tenho 99% de certeza que deixei algo errado, então boa sorte Helion do futuro na hora de debugar essa delíciosa classe de 220 linhas para achar onde tá o problema.
 * 
 * PS. Acho bom começar a olhar com carinho as atualizações do wordpress, pois a probabilidade do wp atualizar e algo quebrar é ALTISSIMO.
 */

class Cadastra_Usuario {
    public static function insere_nas_tabelas($NOME_COMPL, $EMAIL, $SENHA): array {
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
        
        $ID_DO_USUARIO_CRIADO = $wpdb->insert_id;
        $DADOS_CLIENTE = array(
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'wp_capabilities',
                'meta_value' => 'a:1:{s:8:"customer";b:1;}',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'wp_user_level',
                'meta_value' => '0',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'first_name',
                'meta_value' =>  $NOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'last_name',
                'meta_value' => $SOBRENOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'nickname',
                'meta_value' => $NOME . ' ' . $SOBRENOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_first_name',
                'meta_value' => $NOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_last_name',
                'meta_value' => $SOBRENOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_company',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_address_1',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_address_2',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_city',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_postcode',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_country',
                'meta_value' => 'BR',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_state',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_phone',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'billing_email',
                'meta_value' => $EMAIL,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_first_name',
                'meta_value' => $NOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_last_name',
                'meta_value' => $SOBRENOME,
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_company',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_address_1',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_address_2',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_city',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_postcode',
                'meta_value' => '',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_country',
                'meta_value' => 'BR',
            ),
            array(
                'user_id' => $ID_DO_USUARIO_CRIADO,
                'meta_key' => 'shipping_state',
                'meta_value' => '',
            )

        );      ;
        foreach($DADOS_CLIENTE as $linha) {
            $wpdb->insert(
                $wpdb->usermeta, 
                $linha, 
                array('%d','%s','%s'));
        }

            $wpdb->insert(
                $wpdb->prefix . 'wc_customer_lookup',
                array(
                    'user_id' => $ID_DO_USUARIO_CRIADO,
                    'username' => $NOME . ' ' . $SOBRENOME,
                    'first_name' => $NOME,
                    'last_name'=> $SOBRENOME,
                    'email' => $EMAIL,
                    'date_last_active' => current_time('mysql'),
                    'date_registered' => current_time('mysql'),
                    'country' => 'BR'
                ),
                array(
                    '%d','%s','%s','%s','%s','%s','%s','%s'
                )
        );

        $wpdb->insert(
            $wpdb->prefix .'solucoes_users',
            array(
                'ID_USER'=> $ID_DO_USUARIO_CRIADO,
                'user_login' => $NOME_COMPL
            ),
            array(
                '%d','%s'
            )
            );
        return array($wpdb->insert_id, $NOME_COMPL, $SENHA);
    }
} 
?>