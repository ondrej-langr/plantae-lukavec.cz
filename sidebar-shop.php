<?php

$scoped_cat = null;
if ( function_exists( 'is_product_category' ) && is_product_category() ) {
    $scoped_cat = get_queried_object();
} elseif ( ! empty( $_GET['product_cat'] ) ) {
    $term = get_term_by( 'slug', sanitize_title( wp_unslash( $_GET['product_cat'] ) ), 'product_cat' );
    $scoped_cat = ( $term && ! is_wp_error( $term ) ) ? $term : null;
}

$clear_url = $scoped_cat
    ? get_term_link( $scoped_cat )
    : get_permalink( wc_get_page_id( 'shop' ) );
?>

<aside id="content-aside">
  <div class="w-100">
    <form role="search" method="get" class="woocommerce-product-search mb-4" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <label class="screen-reader-text" for="sidebar-product-search-field"><?php esc_html_e( 'Hledat produkty:', 'woocommerce' ); ?></label>
      <div class="flex gap-2">
        <input
          type="search"
          id="sidebar-product-search-field"
          name="s"
          class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#00a900] sm:text-sm/6"
          placeholder="<?php echo esc_attr__( 'Hledat produkty&hellip;', 'woocommerce' ); ?>"
          value="<?php echo get_search_query(); ?>"
          data-clear-url="<?php echo esc_url( $clear_url ); ?>"
        />
        <?php if ( $scoped_cat ) : ?>
        <input type="hidden" name="product_cat" value="<?php echo esc_attr( $scoped_cat->slug ); ?>" />
        <?php endif; ?>
      </div>
      <input type="hidden" name="post_type" value="product" />
    </form>
    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
  </div>
</aside>
<script>
(function () {
  var input = document.getElementById('sidebar-product-search-field');
  if (!input) return;
  input.addEventListener('search', function () {
    if (input.value === '') {
      window.location.href = input.dataset.clearUrl;
    }
  });
}());
</script>
