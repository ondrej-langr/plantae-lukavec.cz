<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$search_query = get_search_query();
$shop_url     = get_permalink( wc_get_page_id( 'shop' ) );

$cat_slug = isset( $_GET['product_cat'] ) ? sanitize_title( wp_unslash( $_GET['product_cat'] ) ) : '';
$cat      = $cat_slug ? get_term_by( 'slug', $cat_slug, 'product_cat' ) : null;

?>
<div class="text-center py-14 px-4 max-w-lg mx-auto">

  <i class="fas fa-search text-5xl text-gray-200 block mb-5"></i>

  <h2 class="font-[Playfair_Display] text-2xl font-medium text-[#1b1b1b] mt-0 mb-3">
    <?php esc_html_e( 'Nic jsme nenašli', 'woocommerce' ); ?>
  </h2>

  <p class="font-[Montserrat] text-sm text-[#888484] leading-relaxed p-0 mb-8">
    <?php if ( $search_query && $cat ) : ?>
      <?php
        printf(
          esc_html__( 'Pro hledání „%1$s" v kategorii „%2$s" jsme nenašli žádné produkty. Zkuste jiný výraz nebo si prohlédněte celý sortiment.', 'woocommerce' ),
          '<strong class="text-[#1b1b1b]">' . esc_html( $search_query ) . '</strong>',
          '<strong class="text-[#1b1b1b]">' . esc_html( $cat->name ) . '</strong>'
        );
      ?>
    <?php elseif ( $search_query ) : ?>
      <?php
        printf(
          esc_html__( 'Pro hledání „%s" jsme nenašli žádné produkty. Zkuste jiný výraz nebo si prohlédněte celý sortiment.', 'woocommerce' ),
          '<strong class="text-[#1b1b1b]">' . esc_html( $search_query ) . '</strong>'
        );
      ?>
    <?php elseif ( $cat ) : ?>
      <?php
        printf(
          esc_html__( 'V kategorii „%s" momentálně nejsou žádné produkty.', 'woocommerce' ),
          '<strong class="text-[#1b1b1b]">' . esc_html( $cat->name ) . '</strong>'
        );
      ?>
    <?php else : ?>
      <?php esc_html_e( 'Žádné produkty neodpovídají vašemu výběru. Zkuste upravit filtry nebo si prohlédněte celý sortiment.', 'woocommerce' ); ?>
    <?php endif; ?>
  </p>

  <div class="flex gap-3 justify-center flex-wrap">
    <a href="<?php echo esc_url( $shop_url ); ?>" class="font-[Montserrat] text-xs tracking-[0.05rem] uppercase no-underline bg-[#00a900] text-white px-5 py-3 rounded">
      <?php esc_html_e( 'Všechny produkty', 'woocommerce' ); ?>
    </a>
    <?php if ( $cat ) : ?>
      <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="font-[Montserrat] text-xs tracking-[0.05rem] uppercase no-underline text-[#1b1b1b] px-5 py-3 rounded border border-[#d8d8d8]">
        <?php echo esc_html( sprintf( 'Všechny produkty v kategorii „%s"', $cat->name ) ); ?>
      </a>
    <?php endif; ?>
  </div>

</div>
