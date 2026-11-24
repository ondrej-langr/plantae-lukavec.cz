<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

$shop_url = wc_get_page_id( 'shop' ) > 0
    ? apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) )
    : null;
?>

<div class="text-center py-14 px-4 max-w-lg mx-auto">

  <div class="relative inline-flex items-center justify-center mb-6">
    <i class="fas fa-shopping-bag text-7xl text-gray-100"></i>
    <i class="fas fa-times text-xl text-gray-300 absolute -bottom-1 -right-1"></i>
  </div>

  <h2 class="font-[Playfair_Display] text-2xl font-medium text-[#1b1b1b] mt-0 mb-3">
    <?php esc_html_e( 'Váš košík je prázdný', 'woocommerce' ); ?>
  </h2>

  <p class="font-[Montserrat] text-sm text-[#888484] leading-relaxed p-0 mb-8">
    <?php esc_html_e( 'Zatím jste do košíku nic nepřidali. Prohlédněte si náš sortiment a najděte, co hledáte.', 'woocommerce' ); ?>
  </p>

  <?php if ( $shop_url ) : ?>
  <div class="flex gap-3 justify-center flex-wrap">
    <a href="<?php echo esc_url( $shop_url ); ?>" class="font-[Montserrat] text-xs tracking-[0.05rem] uppercase no-underline bg-[#00a900] text-white px-5 py-3 rounded inline-flex items-center gap-2">
      <i class="fas fa-seedling"></i>
      <?php esc_html_e( 'Procházet produkty', 'woocommerce' ); ?>
    </a>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-[Montserrat] text-xs tracking-[0.05rem] uppercase no-underline text-[#1b1b1b] px-5 py-3 rounded border border-[#d8d8d8] inline-flex items-center gap-2">
      <i class="fas fa-home"></i>
      <?php esc_html_e( 'Zpět na úvod', 'woocommerce' ); ?>
    </a>
  </div>
  <?php endif; ?>

</div>
