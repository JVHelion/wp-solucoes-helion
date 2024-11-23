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
 * BARALHO, EU TÔ MUITO FERRADO.
 */

/**
 * Cria um endpoint para receber os dados do form
 */

include_once plugin_dir_path(__FILE__) . 'db/cadastra-usuario.php';


 function endpoint_dados_de_cadastro():mixed {
    /**
     * recebe os valores do formulário do elementor
     * @var WP_REST_Request $request
     */
    $raw_content = $request->get_body();
    parse_str(string: $raw_content, result: $parsed_data);


    /**
     * Separa os dados
     * @var mixed $form
     */
    $form = $parsed_data['form'];
    $fields = $parsed_data['fields'];
    $meta = $parsed_data['meta'];


    /**
     * Acessa os dados
     * @var mixed $form_id
     */
    $form_id = $form['id'];
    $form_name = $form['name'];
    $field_name = $fields['name']['value'];
    $field_email = $fields['email']['value'];
    $meta_date = $meta['date']['value'];

    /**
     * 
     */
    return rest_ensure_response(array(
        
    ))

}

function registra_rota_de_cadastro(): void {
    register_rest_route('wp-solucoes/v1', '/cadastra-cliente', array(
        'methods' => WP_REST_Server::CREATABLE,
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