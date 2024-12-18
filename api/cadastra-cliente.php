<?php
/**
 * Ok, vamos planejar.
 * 
 * De acordo com gepeto, se eu quiser criar uma webhook que cria clientes com base no form do elementor, eu tenho que aplicar um insert em:
 * wp_users
 * wp_usermeta
 * wp_wc_customer_lookup
 * wp_solucoes_users
 * 
 * Primeiro eu recebo os dados, filtro eles e então creio que criar uma classe cabulosa de grande que insere tudo numa tacada só seja o mais recomendado. ( ͡° ͜ʖ ͡°)
 * 
 * Não posso esquecer de verificar se já existe algum usuário com mesmo nome. Para não dar conflito entre usuários.
 * O mesmo também para o email.
 * 
 * EU TÔ MUITO FERRADO.
 * 
 * Helion do futuro após ter terminado a classe cabulosa do cadastra-cliente, valeu a pena. Ter feito essa bomba. Ultimo comentário antes de apagar tudo no próximo commit
 */

/**
 * 
 * Importa o cadastra-usuario.php
 * @var mixed $wpdb
 * 
 */
include_once plugin_dir_path(__FILE__) . '../db/cadastra-usuario.php';

/**
 * Cria um endpoint para receber os dados do form
 */
function endpoint_dados_de_cadastro(WP_REST_Request $request): WP_REST_Response {
    // Recebe os valores do formulário do Elementor
    $conteudo_bruto = $request->get_body();
    parse_str(string: $conteudo_bruto, result: $conteudo_convertido);

    // Verifica se todos os campos necessários estão presentes
    if (!isset($conteudo_convertido['fields']['nome_compl']['value']) ||
        !isset($conteudo_convertido['fields']['email']['value']) ||
        !isset($conteudo_convertido['fields']['senha']['value']) ||
        !isset($conteudo_convertido['fields']['lgpd']['value'])) {
        return rest_ensure_response(array(
            'message' => 'Campos obrigatórios não preenchidos',
        ));
    }

    
    $nome_completo = sanitize_text_field($conteudo_convertido['fields']['nome_compl']['value']);
    $email = sanitize_text_field($conteudo_convertido['fields']['email']['value']);
    $senha = sanitize_text_field($conteudo_convertido['fields']['senha']['value']);
    $aceite_lgpd = sanitize_text_field($conteudo_convertido['fields']['lgpd']['value']);

    if ($aceite_lgpd === 'on') {
        list($user_id, $user_login, $user_pass) = Cadastra_Usuario::insere_nas_tabelas(NOME_COMPL: $nome_completo, EMAIL: $email, SENHA: $senha);

        $creds = array(
            'user_login' => $user_login,
            'user_password' => $user_pass,
            'remember' => true
        );

        
        
        // Autentica o usuário
        $usuario = wp_signon($creds, True);
        if (is_wp_error($usuario)){
            return rest_ensure_response(array(
                'message' => 'Erro ao autenticar usuário'. $usuario->get_error_message(),
            ));
        } else {
            return rest_ensure_response(array(
                'message'=> 'Usuário logado com sucesso!',
                

        json_encode(array('HOOK' => 'wp_set_current_user')),
        wp_set_current_user($user_id),

        json_encode(array('HOOK' => 'wp_generate_auth_cookie')),
        wp_generate_auth_cookie($user_id, time() + 1209600, 'logged_in', wp_generate_password(20, false)),

        json_encode(array('HOOK' => 'wp_set_auth_cookie')),
        wp_set_auth_cookie($user_id, True, True),

        json_encode(array('HOOK' => 'WP_Session_Tokens')),
        WP_Session_Tokens::get_instance($user_id),
            ));
        }



    } else {
        return rest_ensure_response(array(
            'message' => 'LGPD não aceito',
        ));
    }
}

function registra_rota_de_cadastro(): void {
    register_rest_route('wp-solucoes/v1', '/cadastra-cliente', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'endpoint_dados_de_cadastro',
    ));
}

add_action('rest_api_init', 'registra_rota_de_cadastro');
?>
