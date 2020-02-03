<?php
/*
Plugin Name: Filtro Customizado
Plugin URI:  http://link to your plugin homepage
Description: Plugoin filtro ejemplo
Version:     0.1
Author:      Slorenzzzo
Author URI:  http://link to your website
License:     GPL2 etc
License URI: http://link to your plugin license
*/


/* Copyright 202 Custom Filter (email : fsancheztemprano@danielcastelao.org)
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


//crear tabla al instalar el plugin
function filter_install(){
	//$charset_collate = $wpdb->get_charset_collate();

	global $wpdb;
	$table_name = "gp_plug_wordfilter";
	
	$sql = "CREATE TABLE $table_name (
		filtered_word varchar(20) NOT NULL,
		filter_to varchar(20) NOT NULL);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook(__FILE__, 'filter_install');


//insertar datos 
function filter_install_data(){
	
	global $wpdb;
	$table_name = "gp_plug_wordfilter";
	
	$wpdb->insert($table_name,array('filtered_word'=> 'wordpress', 'filter_to' => 'WordPress'));
	$wpdb->insert($table_name,array('filtered_word'=> 'goat', 'filter_to' => 'coffee'));
	$wpdb->insert($table_name,array('filtered_word'=> 'Easter', 'filter_to' => 'Easter holidays'));
	$wpdb->insert($table_name,array('filtered_word'=> '70', 'filter_to' => 'seventy'));
	$wpdb->insert($table_name,array('filtered_word'=> 'sensational', 'filter_to' => 'extraordinary'));
	
}
register_activation_hook(__FILE__, 'filter_install_data');

//Desactivar el plugin hace un drop table
function filter_remove(){
	global $wpdb;
	$table_name = "gp_plug_wordfilter";
	$sql = "DROP TABLE IF EXISTS $table_name;";
	$wpdb->query($sql);
}
register_deactivation_hook(__FILE__, "filter_remove");



// function plug_wordfilter_activate(){
// 	$table_name = "gp_plug_wordfilter";
// 	$result = $wpdb->get_results("Select * from $table_name");
// 	echo $result;
// }
// add_action(__FILE__, 'plug_wordfilter_activate');




/*Use this function to replace a single word*/
/*
function renym_wordpress_typo_fix( $text ) {
	return str_replace( 'wordpress', 'WordPress', $text );
}
add_filter( 'the_content', 'renym_wordpress_typo_fix' );
*/


/*Or use this function to replace multiple words or phrases at once*/
// obtenemos las palabras a filtrar de la base de datos
function renym_content_replace( $content ) {
	
	global $wpdb;
	$table_name = 'gp_plug_wordfilter';
	
	$filtered_words = array();
	$filter_tos = array();
	
	$results = $wpdb->get_results("SELECT * from $table_name");
	foreach($results as $result){
		array_push($filtered_words, $result->filtered_word);
		array_push($filter_tos, $result->filter_to);
	}
	
	
	//$search  = array( 'wordpress', 'goat', 'Easter', '70', 'sensational' );
	//$replace = array( 'WordPress', 'coffee', 'Easter holidays', 'seventy', 'extraordinary' );
	return str_replace( $filtered_words, $filter_tos, $content );
}
add_filter( 'the_content', 'renym_content_replace' );

/*Use this function to add a note at the end of your content*/
function renym_content_footer_note( $content ) {
	$content .= '<footer class="renym-content-footer">Thank you for reading this tutorial. Maybe next time I will let you buy me a coffee! For more WordPress tutorials visit our <a href="http://wpexplorer.com/blog" title="WPExplorer Blog">Blog</a></footer><br>list:<br>';

	// global $wpdb;
	// $table_name = 'gp_plug_wordfilter';
	// $results = $wpdb->get_results("SELECT * from $table_name");
	// foreach($results as $result){
	// 	$content .= $result;
	// }
	return $content;
}
add_filter( 'the_content', 'renym_content_footer_note' );

?>