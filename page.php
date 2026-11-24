<?php
/*
Template Name: Normal page template
*/
 ?>

<?php get_header(); ?>
  <main scope="site" type="page">
    <div id="content-section" class="">
      <?php while (have_posts()): the_post()?>
        <?php the_content();?>
      <?php endwhile;?>
      <?php comments_template('', true)?>
    </div>
  </main>
<?php get_footer();?>
