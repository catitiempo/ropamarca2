<?php
/**
 * CustomPermalinks Uninstall
 *
 * Deletes Option and Post Permalinks on uninstalling the Plugin.
 *
 * @package CustomPermalinks/Uninstaller
 * @since 1.2.18
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
  exit;
}

delete_post_meta_by_key( 'custom_permalink' );
delete_option( 'custom_permalink_table' );

// Clear any cached data that has been removed
wp_cache_flush();
