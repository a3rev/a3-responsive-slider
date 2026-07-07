<?php
/**
 * Functions used to duplicate a slider
 *
 * Based on 'Duplicate Post' (http://www.lopo.it/duplicate-post-plugin/) by Enrico Battocchi
 *
 */

namespace A3Rev\RSlider;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Duplicate 
{
	
	public static function duplicate_action() {
		self::duplicate_item();	
	}
	
	public static function duplicate_link_row( $actions, $post ) {
	
		if ( function_exists( 'duplicate_post_plugin_activation' ) ) return $actions;
				
		if ( $post->post_type != 'a3_slider' ) return $actions;
		
		$actions['duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'admin.php?action=duplicate_a3_slider&amp;post=' . $post->ID ), 'a3-duplicate-slider_' . $post->ID ) . '" title="' . __( "Make a duplicate from this slider", 'a3-responsive-slider' )
			. '" rel="permalink">' .  __( "Duplicate", 'a3-responsive-slider' ) . '</a>';
	
		return $actions;
	}
	
	public static function duplicate_post_button() {
		global $post;
		
		if ( function_exists( 'duplicate_post_plugin_activation' ) ) return;
				
		if( !is_object( $post ) ) return;
		
		if ( $post->post_type != 'a3_slider' ) return;
		
		if ( isset( $_GET['post'] ) ) :
			$notifyUrl = wp_nonce_url( admin_url( "admin.php?action=duplicate_a3_slider&post=" . absint( $_GET['post'] ) ), 'a3-duplicate-slider_' . absint( $_GET['post'] ) );
			?>
			<div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Duplicate', 'a3-responsive-slider' ); ?></a></div>
			<?php
		endif;
	}

	public static function duplicate_item() {
		if ( ! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duplicate_post_save_as_new_page' == $_REQUEST['action'] ) ) ) {
			wp_die( __( 'No slider to duplicate has been supplied!', 'a3-responsive-slider' ) );
		}

		// Get the original page
		$id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		check_admin_referer( 'a3-duplicate-slider_' . $id );
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( -1, 403 );
		}
		$post = self::get_item_to_duplicate( $id );
	
		// Copy the page and insert it
		if ( isset( $post ) && $post != null ) {
			$new_id = self::create_duplicate_from_item( $post );
	
			// If you have written a plugin which uses non-WP database tables to save
			// information about a page you can hook this action to dupe that data.
			do_action( 'duplicate_item', $new_id, $post );
	
			// Redirect to the edit screen for the new draft page
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
			exit;
		} else {
			wp_die( __( 'Slider creation failed, could not find original slider:', 'a3-responsive-slider' ) . ' ' . $id);
		}
	}
	
	/**
	 * Get a product from the database
	 */
	public static function get_item_to_duplicate( $id ) {
		global $wpdb;
		$post = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( isset( $post->post_type ) && $post->post_type === 'revision' ) {
			$id   = $post->post_parent;
			$post = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		}
		return $post;
	}
	
	/**
	 * Function to create the duplicate
	 */
	public static function create_duplicate_from_item( $post, $parent = 0, $post_status = '' ) {
		$new_post_author   = wp_get_current_user();
		$new_post_date     = current_time( 'mysql' );
		$new_post_date_gmt = get_gmt_from_date( $new_post_date );

		if ( $parent > 0 ) {
			$post_parent = $parent;
			$post_status = $post_status ? $post_status : 'publish';
			$suffix      = '';
		} else {
			$post_parent = $post->post_parent;
			$post_status = $post_status ? $post_status : 'publish';
			$suffix      = ' ' . __( '(Copy)', 'a3-responsive-slider' );
		}

		$new_post_id = wp_insert_post( array(
			'post_author'           => $new_post_author->ID,
			'post_date'             => $new_post_date,
			'post_date_gmt'         => $new_post_date_gmt,
			'post_content'          => $post->post_content,
			'post_content_filtered' => $post->post_content_filtered,
			'post_title'            => $post->post_title . $suffix,
			'post_excerpt'          => $post->post_excerpt,
			'post_status'           => $post_status,
			'post_type'             => $post->post_type,
			'comment_status'        => $post->comment_status,
			'ping_status'           => $post->ping_status,
			'post_password'         => $post->post_password,
			'to_ping'               => $post->to_ping,
			'pinged'                => $post->pinged,
			'post_parent'           => $post_parent,
			'menu_order'            => $post->menu_order,
			'post_mime_type'        => $post->post_mime_type,
		), false );

		if ( ! $new_post_id ) {
			return 0;
		}

		// Copy the taxonomies
		self::duplicate_post_taxonomies( $post->ID, $new_post_id, $post->post_type );

		// Copy the meta information
		self::duplicate_post_meta( $post->ID, $new_post_id );

		// Update the slider id meta
		self::update_slider_id_meta( $post->ID, $new_post_id );

		// Copy the images for slider
		self::duplicate_post_images( $post->ID, $new_post_id );

		return $new_post_id;
	}
	
	/**
	 * Copy the taxonomies of a post to another post
	 */
	public static function duplicate_post_taxonomies( $id, $new_id, $post_type ) {
		global $wpdb;
		$taxonomies = get_object_taxonomies( $post_type ); //array("category", "post_tag");
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms($id, $taxonomy);
			$post_terms_count = sizeof( $post_terms );
			for ( $i=0; $i < $post_terms_count; $i++ ) {
				wp_set_object_terms( $new_id, $post_terms[$i]->slug, $taxonomy, true);
			}
		}
	}
	
	/**
	 * Copy the meta information of a post to another post
	 */
	public static function duplicate_post_meta( $id, $new_id ) {
		$all_custom_keys = get_post_custom_keys( $id );
		foreach ( $all_custom_keys as $key ) {
			$value = get_post_meta( $id, $key, true );
			add_post_meta( $new_id, $key, $value );
		}
	}
	
	/**
	 * Update the slider id meta
	 */
	public static function update_slider_id_meta( $id, $new_id ) {
		update_post_meta( $new_id, '_a3_slider_id', $new_id );
	}
	
	
	/**
	 * Copy the images of original slider to another post
	 */
	public static function duplicate_post_images( $id, $new_id ) {
		$all_images = Data::get_all_images_from_slider( $id );
		if ( is_array( $all_images ) && count( $all_images ) > 0 ) {
			foreach ( $all_images as $a_image ) {
				if ( $a_image->is_video == 0 ) 
					Data::insert_row_image( $new_id, $a_image->img_url, $a_image->img_link, $a_image->img_title, $a_image->img_description, $a_image->img_alt, $a_image->img_order, $a_image->show_readmore, $a_image->open_newtab );
			}
		}
	}
}
