<?php 
/*
  Plugin Name: WordPress Mini Aggregator
  Plugin URI: -
  Description: Allows you to easily embed a list of blogs RSS
  Author: Ionuț Staicu
  Version: 0.1
  Author URI: http://iamntz.com
  License: GPL v2 or later
*/

class Ntz_Mini_Agregator{
  function __construct(){
    add_shortcode( 'mini-aggregator', array( &$this, 'add_shortcode' ) );
  }

  public function add_shortcode( $atts, $rss_feeds = null ){
    $parsed_rss = '';
    extract( shortcode_atts( array(
      "max_items_to_fetch" => 2
    ), $atts ) );

    if( $rss_feeds ){
      include_once( ABSPATH . WPINC . '/feed.php' );

      $blogs = array();

      $rss_feeds = explode( "\n", $rss_feeds );

      foreach( (array) $rss_feeds as $rss_feed ){
        $rss_feed = strip_tags( $rss_feed );
        if( !empty( $rss_feed ) ){
          $rss = fetch_feed( $rss_feed );
          if ( !is_wp_error( $rss ) ){
            $maxitems = $rss->get_item_quantity( $max_items_to_fetch );
            $feed = $rss->get_items( 0, $maxitems );
            $blogs[] = array(
              "feed" => $feed,
              "date" => strtotime( $feed[0]->get_date() )
            );
          }
        }
      }

      usort( $blogs, array( $this, 'sort_rss_by_date' ) );

      foreach( (array) $blogs as $rss_items ){
        $parsed_rss .= sprintf( '<h2>%s - %s</h2>',
          ucwords( $rss_items['feed'][0]->get_feed()->get_title() ),
          ucwords( $rss_items['feed'][0]->get_feed()->get_description() )
        );

        $parsed_rss .= '<ul>';

        foreach( $rss_items['feed'] as $rss_item ){
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


  public function sort_rss_by_date( $b, $a ){
    return strcmp($a['date'], $b['date']);
  } // sort_rss_by_date
}

new Ntz_Mini_Agregator();