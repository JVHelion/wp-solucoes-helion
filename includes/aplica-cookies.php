<?php

function incluir_arquivo_na_pagina(): void {
    if (is_page('compra-online')) {
        include_once plugin_dir_path(__FILE__) . '../includes/aplica-cookies.php';
    }
}


add_action('wp', 'incluir_arquivo_na_pagina');


?>