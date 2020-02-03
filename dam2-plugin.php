<?php
/*
Plugin Name: dam2 plugin
Plugin URI:  http://example.com/dam2
Description: This plugin replaces words with your own choice of words.
Version:     1.0
Author:      slorenzzzo
Author URI:  SLRSite
License:     GPL2 etc
License URI: https://link to your plugin license

Copyright YEAR PLUGIN_AUTHOR_NAME (email : your email address)
(Plugin Name) is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
(Plugin Name) is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with (Plugin Name). If not, see (http://link to your plugin license).
*/

//función camibar palabras
function renym_wordpress_typo_fix( $text ) {
return str_replace( 'wordpress', 'WordPressDAM', $text );
}

add_filter( 'the_content', 'renym_wordpress_typo_fix' );


//funcion pista contraseña 

 function contrasinal_olvidada(){
      return 'la contraseña es: c******';
   }
   add_filter( 'login_errors', 'contrasinal_olvidada' );
   
  function renym_content_footer_note( $content ) {
	$content .= '<footer class="renym-content-footer">¡gracias por visitarnos!</a></footer>';
	return $content;
}
add_filter( 'the_content', 'renym_content_footer_note' );

   
 
 global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'dam2';

// creamos la sentencia sql

$sql = "CREATE TABLE $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
name tinytext NOT NULL,
text text NOT NULL,
url varchar(55) DEFAULT '' NOT NULL,
PRIMARY KEY (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

?>