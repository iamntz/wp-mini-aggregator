<?php 
/*
  Plugin Name: WordPress Mini Agregator
  Plugin URI: -
  Description: Allows you to easily embed a list of blogs RSS
  Author: Ionuț Staicu
  Version: 0.1
  Author URI: http://iamntz.com
  License: GPL v2 or later
*/

/**
* asds
*/
class Ntz_Mini_Agregator{
  function __construct(){
    add_shortcode( 'mini-agregator', array( &$this, 'add_shortcode' ) );
  }

  public function add_shortcode( $atts, $rss_feeds = null ){
    $parsed_rss = '';
    extract( shortcode_atts( array(
      "update_interval" => 1
    ), $atts ) );

    if( $rss_feeds ){
      $blogs = array();

      include_once( ABSPATH . WPINC . '/feed.php' );
      $rss_feeds = explode( "\n", $rss_feeds );
      foreach( (array) $rss_feeds as $rss_feed ){
        $rss_feed = strip_tags( $rss_feed );
        if( !empty( $rss_feed ) ){
          $rss = fetch_feed( $rss_feed );
          if ( !is_wp_error( $rss ) ){
            $maxitems = $rss->get_item_quantity( 5 );
            $blogs[] = $rss->get_items( 0, $maxitems );
          }
        }
      }

      foreach( (array) $blogs as $rss_items ){
        $parsed_rss .= '<ul>';
        $parsed_rss .= sprintf( '<li><h2>%s</h2></li>',
          $rss_items[0]->get_feed()->get_title()
        );

        foreach( $rss_items as $rss_item ){
            $parsed_rss .= '<li>';
            $parsed_rss .= sprintf( '<a href="%s">%s</a>', 
              $rss_item->get_permalink(),
              $rss_item->get_title()
            );
        }
        $parsed_rss .= '</ul>';
      }
    }

    return $parsed_rss;
  } // add_shortcode
}

new Ntz_Mini_Agregator();