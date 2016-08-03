<?php
function meuEcho($x) {
	echo '<pre style="color:#fff; text-align: left; font-size: 14px;">';
	print_r($x);
	echo '</pre>';
}
function antiInjection($str) {
  # Remove palavras suspeitas de injection.
  $str = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|.php|to:|cc:|Autoreply:|from|select|insert|delete|where|drop
table|show tables|#|\*|--|\\\\)/"), "", $str);
  $str = trim($str);        # Remove espaços vazios.
  $str = strip_tags($str);  # Remove tags HTML e PHP.
  $str = addslashes($str);  # Adiciona barras invertidas à uma string.
  return $str;
}
function myConfigs() {
  //Retorna todas as opções de configuração como uma matriz associativa.
  //Se o parâmetro opcional extension estiver definido, apenas as opções especificas para esta extensão serão retornadas.
  $inis = ini_get_all();
  print_r($inis);
}

function slugfy($str) {
    
    function tirarAcentos($string) {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    }

    function sanitize($string) {
      $s = str_replace(array("*","?", "--", "%", "'", "&", "#", "\"", "/", ",", ";"),"", $string);
    }

    $s = tirarAcentos($str);
    $s = sanitize($s);
    $s = strtolower(str_replace(' ', '-', trim($s)));
    return $s;

}

function get_ip() {
  return getenv("REMOTE_ADDR"); // obtém o número ip do usuário
}

function paginationWP() {
  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

  $args = array(
    'post_type' => 'howWeWork',
    'posts_per_page' => 12,
    'orderby'=> 'menu_order',
    'order'=>'ASC',
    'paged' => $paged
  );

  // The Query
  $the_query = new WP_Query( $args );

  // The Loop
  if ( $the_query->have_posts() ) {
          echo '<ul>';
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      echo '<li>' . get_the_title() . '</li>';
    }
          echo '</ul>';
  } else {
    // no posts found
  }
  /* Restore original Post Data */
  wp_reset_postdata();
}
function createTable(){

$sql = "CREATE TABLE `logs` (
  `id` INT(12) UNSIGNED AUTO_INCREMENT,
  `tipo` VARCHAR(50) NULL COLLATE 'utf8_bin',
  `id_lead` BIGINT(20) UNSIGNED NULL,
  `id_usuario` INT(9) UNSIGNED NOT NULL,
  `obs` TEXT NULL COLLATE 'utf8_bin',
  `data` DATETIME NULL,
  PRIMARY KEY (id),
  CONSTRAINT `fk_id_lead` FOREIGN KEY (id_lead) REFERENCES leads (id_lead),
  CONSTRAINT `fk_id_usuario` FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
)
COLLATE='utf8_bin'
ENGINE=InnoDB
";

}

/* INIT HELPRES */

function my_debug(&$variavel, $type = 'print'){
  
  echo '<pre>';

  if( is_null($variavel) ){
    echo "NULL";
  }
  
  if ( is_array( $variavel ) || is_object( $variavel ) ) {

    if ( $type == 'print' ) {
      print_r($variavel);
    } else {
      var_dump($variavel);
    }

  } else {
    echo $variavel;
  }

  echo '<br></pre>';
}

//my functions to get curretn category on page archive
function my_get_current_category(){

  $args = array(
      'orderby' => 'name',
      'order' => 'ASC'
  );
   
  $categories = get_categories($args);

  foreach ($categories as $key => $value) {
      if( is_category( $value->slug ) )
          return $value;
  }
  return false;

}

//chamar a função dentro do loop de posts ou não funciona
function my_get_thumb($size = 'full') {
  
  if( has_post_thumbnail() ) {
      $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
      return $thumb[0];
    }

    return IMG_PATH . 'default.jpg';
}

//converte cores hexadecimais em um array rgb. exp.: array ( 255, 241, 0, 1 );
function hex_to_rgb($hex, $alpha = 1) {

  if($alpha > 1 OR $alpha < 0){
    $alpha = 1;
  }

    $hex = str_replace("#", "", $hex);

  if(strlen($hex) == 3) {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  } else {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
  }
  
  $rgb = array($r, $g, $b, $alpha);

  return $rgb;
}

/* END HELPRES */