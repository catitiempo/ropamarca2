<?php use Premmerce\UrlManager\UrlManagerPlugin; ?>
<form method="post" action="options.php">
	<?php settings_fields('premmerce-url-manager-group'); ?>
    <table class="form-table">
        <tbody>
        <tr>
            <th><?php _e('Category', UrlManagerPlugin::DOMAIN) ?></th>
			<?php $checked = isset($options['remove_category_base'])? 'checked' : '' ?>
            <td>
                <fieldset>
                    <label>
                        <input type="checkbox"
                               name="<?php echo UrlManagerPlugin::OPTION_URL ?>[remove_category_base]" <?php echo $checked ?>>
						<?php _e('Remove base', UrlManagerPlugin::DOMAIN) ?>
                    </label>
                    <p class="description">
						<?php _e('Remove prefix from category URL<br> default: /product-category/accessories/action-figures/ - changed: /accessories/action-figures/', UrlManagerPlugin::DOMAIN) ?>
                    </p>
                    <br>
                    <label>
						<?php $checked = isset($options['remove_category_parent_slugs'])? 'checked' : '' ?>
                        <input type="checkbox"
                               name="<?php echo UrlManagerPlugin::OPTION_URL ?>[remove_category_parent_slugs]" <?php echo $checked ?>>
						<?php _e('Remove parent slugs', UrlManagerPlugin::DOMAIN); ?>
                    </label>
                    <p class="description">
						<?php _e('Remove parent slugs from category URL<br> default: /product-category/accessories/action-figures/ - changed: /product-category/action-figures/', UrlManagerPlugin::DOMAIN) ?>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th>
				<?php _e('Product', UrlManagerPlugin::DOMAIN) ?>
            </th>
            <td>
                <fieldset>
                    <label>
						<?php $checked = isset($options['remove_product_base'])? 'checked' : '' ?>
                        <input type="checkbox"
                               name="premmerce_url_manager_options[remove_product_base]" <?php echo $checked ?>>
						<?php _e('Remove base', UrlManagerPlugin::DOMAIN) ?>
                    </label>
                    <p class="description">
						<?php _e('Remove prefix from product URL<br> default: /shop/accessories/action-figures/acme/ - changed: /accessories/action-figures/acme/', UrlManagerPlugin::DOMAIN) ?>
                    </p>
                </fieldset>
            </td>
        </tr>
        </tbody>
    </table>
	<?php submit_button(); ?>
</form>