<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Output plugin page
 *
 * @since 1.0.0
 */
function __wptcmf_tools_page() {
	$count_domains = count( $GLOBALS['wptcmf_text_domains'] ); ?>

	<div class="wptcmf-options-page wrap">
		<img src="<?php echo esc_url( WPTCMF_URL_IMG . 'wpt-logo.png' ); ?>"><h2><?php esc_html_e( WPTCMF_NICE_NAME ); ?></h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'wptcmf_options' ); ?>
			<?php if ( 0 < $count_domains ) : ?>
				<?php do_settings_sections( 'wptcmf_rules' ); ?>
				<?php submit_button( __( 'Add new rule', 'wpt-custom-mo-file' ), 'primary', 'wptcmf_options[wptcmf-add-rule]' ); ?>
			<?php else : ?>
				<div class="settings-error notice notice-info is-dismissible"><p><strong><?php  esc_html_e( 'There is no available textdomain. ', 'wpt-custom-mo-file' ); ?></strong></p></div>
			<?php endif; ?>
			<?php do_settings_sections( 'wptcmf_rules_actions' ); ?>
		</form>
	</div>

	<?php
}

/**
 * Output rules section text
 *
 * @since 1.0.0
 */
function __wptcmf_section_rules_text() {
	?>
	<p><?php esc_html_e( 'Create, activate, desactivate your own set of rules to get full control of any translations in your WordPress installation.', 'wpt-custom-mo-file' ); ?></p>
	<?php
}

/**
 * Output input file field
 *
 * @since 1.0.0
 */
function __wptcmf_upload_mo_file_field() {
	?>
	<input id="wptcmf_upload_mo_file" name="wptcmf_mo_file" type="file">
	<?php
}

/**
 * Output textdomain select field
 *
 * @since 1.0.0
 */
function __wptcmf_select_textdomain_field() {
	$domains = $GLOBALS['wptcmf_text_domains'];
	asort( $domains ); ?>
	
	<select id="wptcmf_select_textdomain" name="wptcmf_options[text_domain]">
		<?php foreach ( $domains as $domain ) : ?>
			<option value="<?php esc_attr_e( $domain ); ?>"><?php echo esc_attr_e( $domain ); ?></option>
		<?php endforeach; ?>
	</select>

	<?php
}

/**
 * Output languages select field
 *
 * @since 1.0.0
 */
function __wptcmf_select_language_field() {
	$locale = get_locale();
	$args = array(
		'id' => 'wptcmf_select_languages',
		'name' => 'wptcmf_options[language]',
		'selected' => $locale,
	);
	wp_dropdown_languages( $args );

}

/**
 * Output rules table
 *
 * @since 1.0.0
 */
function __wptcmf_rules_table_field() {
	global $l10n;
	$rules = get_option( 'wptcmf_options' );
	$count_rules = count( $rules['rules'] );
	$locale = get_locale();

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) : ?>

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'wpt-custom-mo-file' ); ?></label>
				<select name="wptcmf_options[bulk_action_top]" id="bulk-action-selector-top">
					<option value="-1"><?php esc_html_e( 'Bulk actions', 'wpt-custom-mo-file' ); ?></option>
					<option value="activate"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></option>
					<option value="deactivate"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></option>
					<option value="delete"><?php esc_html_e( 'Delete', 'wpt-custom-mo-file' ); ?></option>
				</select>
				<button name="wptcmf_options[action_top]" class="button" type="submit"><?php esc_html_e( 'Apply', 'wpt-custom-mo-file' ); ?></button>
			</div>
			<div class="tablenav-pages"><span class="displaying-num"><?php printf( esc_html( _n( '%d item.', '%d items.', absint( $count_rules ), 'wpt-custom-mo-file' ) ), absint( $count_rules ) ); ?></span></div>
			<br class="clear">
		</div>

		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<td id="cb" class="column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1"><?php esc_html_e( 'Select All', 'wpt-custom-mo-file' ); ?></label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Language', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Filename', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $rules['rules'] as $lang ) : ?>
					<?php foreach ( $lang as $rule ) : ?>
					<tr>
						<th scope="row" class="check-column">
							<label class="screen-reader-text" for="cb-select-<?php esc_attr_e( $rule['text_domain'].'-'.$rule['language'] ); ?>"><?php esc_html_e( 'Select&nbsp;', 'wpt-custom-mo-file' ); ?><?php echo esc_html( $rule['text_domain'] ); ?></label>
							<input name="wptcmf_options[mo][]" id="cb-select-<?php esc_attr_e( $rule['text_domain'].'-'.$rule['language'] ); ?>" value="<?php esc_attr_e( $rule['text_domain'].'|'.$rule['language'] ); ?>" type="checkbox">
						</th>
						<td><?php esc_attr_e( $rule['text_domain'] ); ?></td>
						<td><?php esc_attr_e( $rule['language'] ); ?></td>
						<td><?php esc_attr_e( $rule['filename'] ); ?></td>
						<td>
							<?php if ( 1 === $rule['activate'] ) : ?>
								<button class="button wptcmf-button wptcmf-button-deactivate" type="submit" name="wptcmf_options[deactivate_rule]" value="<?php esc_attr_e( $rule['text_domain'].'|'.$rule['language'] ); ?>"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></button>
							<?php else : ?>
								<button class="button wptcmf-button wptcmf-button-activate" type="submit" name="wptcmf_options[activate_rule]" value="<?php esc_attr_e( $rule['text_domain'].'|'.$rule['language'] ); ?>"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></button>
							<?php endif; ?>
							<button class="button wptcmf-button wptcmf-button-delete" type="submit" name="wptcmf_options[delete_rule]" value="<?php esc_attr_e( $rule['text_domain'].'|'.$rule['language'] ); ?>"><?php esc_html_e( 'Delete rule', 'wpt-custom-mo-file' ); ?></button>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td id="cb" class="column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Language', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Filename', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</tfoot>
		</table>

		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-bottom" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'wpt-custom-mo-file' ); ?></label>
				<select name="wptcmf_options[bulk_action_bottom]" id="bulk-action-selector-bottom">
					<option value="-1"><?php esc_html_e( 'Bulk actions', 'wpt-custom-mo-file' ); ?></option>
					<option value="activate"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></option>
					<option value="deactivate"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></option>
					<option value="delete"><?php esc_html_e( 'Delete', 'wpt-custom-mo-file' ); ?></option>
				</select>
				<button name="wptcmf_options[action_bottom]" class="button" type="submit"><?php esc_html_e( 'Apply', 'wpt-custom-mo-file' ); ?></button>
			</div>
			<div class="tablenav-pages"><span class="displaying-num"><?php printf( esc_html( _n( '%d item.', '%d items.', absint( $count_rules ), 'wpt-custom-mo-file' ) ), absint( $count_rules ) ); ?></span></div>
			<br class="clear">
		</div>

	<?php endif;
}

/**
 * Custom footer text left
 *
 * @since 1.0.0
 * @return string
 */
add_filter( 'admin_footer_text', '__wptcmf_filter_admin_footer_text' );
function __wptcmf_filter_admin_footer_text( $text ) {
	$screen = get_current_screen();
	if ( 'tools_page_' . WPTCMF_SLUG !== $screen->base ) {
		return $text;
	} else {
		$link_1 = '<a href="http://wp-translations.org/" target="_blank">WP-Translations</a>';
		$link_2 = '<a target="_blank" href="http://wordpress.org/support/plugin/wpt-custom-mo-file#postform">';
		$link_3 = '</a>';
		$change = str_replace(
			array( '[stars]', '[wp.org]' ),
			array( '<a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/wpt-custom-mo-file#postform" >&#9733;&#9733;&#9733;&#9733;&#9733;</a>', '<a target="_blank" href="http://wordpress.org/plugins/wpt-custom-mo-file/" >wordpress.org</a>' ),
			esc_html_x( 'Add your [stars] on [wp.org] to spread the love.', 'Please do not translate [stars] and [wp.org]', 'wpt-custom-mo-file' )
		);
		return sprintf( esc_html__( 'Visit %1$s Community website | %2$s Contact Support %3$s | %4$s', 'wpt-custom-mo-file' ), $link_1, $link_2, $link_3, $change );
	}
}

/**
 * Custom footer text right
 *
 * @since 1.0.0
 * @return string
 */
add_filter( 'update_footer', '__wptcmf_filter_update_footer', 15 );
function __wptcmf_filter_update_footer( $text ) {
	$screen = get_current_screen();
	if ( 'tools_page_' . WPTCMF_SLUG !== $screen->base ) {
		return $text;
	} else {
		$translate = sprintf( '<a class="wptcmf-footer-link" href="https://translate.wordpress.org/projects/wp-plugins/wpt-custom-mo-file" title="%s"><span class="dashicons dashicons-translation"></span></a>', esc_html__( 'Help us with Translations', 'wpt-custom-mo-file' ) );
		$version = esc_html__( 'Version:&nbsp;', 'wpt-custom-mo-file' ) . WPTCMF_VERSION;
		return $translate . $version;
	}
}
