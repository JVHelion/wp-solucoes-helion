SET 
  @NOME_COMPL = 'teste banco3';

SET 
  @EMAIL = 'teste.banco3@teste.com';

SET 
  @SENHA = '123321213231';
  
SET
  @NOME = SUBSTRING_INDEX(@NOME_COMPL, ' ', 1);
  
SET
  @SOBRENOME = SUBSTRING_INDEX(@NOME_COMPL, ' ', -1);

INSERT INTO wp_users(
  user_login, user_pass, user_nicename, 
  user_email, user_url, user_registered, 
  user_activation_key, user_status, 
  display_name
) 
select 
  @NOME_COMPL, 
  md5(@SENHA), 
  @NOME_COMPL, 
  @EMAIL, 
  '', 
  NOW(), 
  '', 
  0, 
  @NOME_COMPL;
  
SET 
  @user_id = LAST_INSERT_ID();
-- Inserir os metadados do usuário na tabela wp_usermeta 
INSERT INTO wp_usermeta (user_id, meta_key, meta_value) 
VALUES 
  (
    @user_id, 'wp_capabilities', 'a:1:{s:8:"customer";b:1;}'
  ), 
  (@user_id, 'wp_user_level', '0'), 
  (@user_id, 'first_name', @NOME), 
  (@user_id, 'last_name', @SOBRENOME), 
  (
    @user_id, 'nickname', @NOME_COMPL
  ), 
  (
    @user_id, 'billing_first_name', @NOME
  ), 
  (
    @user_id, 'billing_last_name', @SOBRENOME
  ), 
  (@user_id, 'billing_company', ''), 
  (
    @user_id, 'billing_address_1', ''
  ), 
  (
    @user_id, 'billing_address_2', ''
  ), 
  (
    @user_id, 'billing_city', ''
  ), 
  (
    @user_id, 'billing_postcode', ''
  ), 
  (
    @user_id, 'billing_country', 'BR'
  ), 
  (@user_id, 'billing_state', ''), 
  (
    @user_id, 'billing_phone', ''
  ), 
  (
    @user_id, 'billing_email', @EMAIL
  ), 
  (
    @user_id, 'shipping_first_name', @NOME
  ), 
  (
    @user_id, 'shipping_last_name', @SOBRENOME
  ), 
  (@user_id, 'shipping_company', ''), 
  (
    @user_id, 'shipping_address_1', ''
  ), 
  (
    @user_id, 'shipping_address_2', ''
  ), 
  (
    @user_id, 'shipping_city', ''
  ), 
  (
    @user_id, 'shipping_postcode', ''
  ), 
  (
    @user_id, 'shipping_country', 'BR'
  ), 
  (@user_id, 'shipping_state', '');


INSERT INTO wp_wc_customer_lookup (user_id, username, first_name, last_name, email, date_last_active, date_registered, country)
SELECT
@user_id,
@NOME_COMPL,
@NOME,
@SOBRENOME,
@EMAIL,
NOW(),
NOW(),
'BR';

INSERT INTO wp_solucoes_users(ID_USER, user_login)
SELECT
@user_id,
@NOME_COMPL
