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
 */

/**
 * Cria um endpoint para receber os dados do form
 */


 function endpoint_dados_de_cadastro():mixed {
    return rest_ensure_response('primeiro teste do helion');
}

function registra_rota_de_cadastro(): void {
    register_rest_route('wp-solucoes/v1', '/cadastra-cliente', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'endpoint_dados_de_cadastro',
    ));
}

add_action('rest_api_init', 'registra_rota_de_cadastro');




// class cria_cliente_devagarzinho_pros_cria {
//     public static insert_nas_tabelas_wp() {
//         global $wpdb;
        
//     }
// }
?>