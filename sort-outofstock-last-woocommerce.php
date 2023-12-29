<?php
/**
 * Plugin Name: Sort Out of Stock Products Last for WooCommerce
 * Plugin URI: https://www.sprucely.net/
 * Description: Sorts out-of-stock WooCommerce products to display them at the end of product lists, maintaining other sorting orders.
 * Version: 1.0
 * Author: Isaac Russell @ Sprucely Designed
 * Author URI: https://www.sprucely.net
 */

// Ensures no direct access to this file.
defined('ABSPATH') || exit;

/**
 * Modifies WooCommerce product query to display out-of-stock items last.
 * 
 * @param array $args The current query arguments.
 * @return array Modified query arguments.
 */
function sprucely_sort_out_of_stock_last_for_wc($args) {
    // Add a custom sort clause based on stock status
    $args['meta_query']['sort_stock_status_clause'] = array(
        'key' => '_stock_status'
    );

    // Handle existing 'orderby' and 'order'
    $default_orderby = is_array($args['orderby']) ? $args['orderby'] : explode(' ', $args['orderby']);

    // Set custom sort, then append default orderby values
    $args['orderby'] = array('sort_stock_status_clause' => 'ASC');
    foreach ($default_orderby as $key => $value) {
        $args['orderby'][$key] = $args['order'];
    }

    return $args;
}

// Adding filters for WooCommerce catalog and shortcode product queries
add_filter('woocommerce_get_catalog_ordering_args', 'sprucely_sort_out_of_stock_last_for_wc');
add_filter('woocommerce_shortcode_products_query', 'sprucely_sort_out_of_stock_last_for_wc');
