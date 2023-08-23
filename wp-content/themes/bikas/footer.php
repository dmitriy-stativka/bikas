<?php

$build_folder = get_template_directory_uri() . '/assets/build/';

/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package    WordPress
 * @subpackage Twenty_Twelve
 * @since      Twenty Twelve 1.0
 */

?>
</div><!-- #main .wrapper -->
<footer id="colophon" class="footer">
  <div class="container">
    <div class="footer__inner">
      <a href="/" class="footer__logo">
        <?php $logo = get_field( 'logo', 'options' );
          if ( $logo ) : ?>
          <img src="<?php echo esc_url( $logo['url'] ); ?>" 
          alt="<?php echo esc_attr( $logo['alt'] ); ?>" />
        <?php endif; ?>
      </a>

      <div class="footer__coll">
          <nav class='footer__nav'>
            <ul class="alt-menu">
              <li><a href="#">Жіночи куртки</a></li>
              <li><a href="#">Чоловічи куртки</a></li>
              <li><a href="#">Акціі</a></li>
              <li><a href="#">усі новинки</a></li>
              <li><a href="#">бестселери</a></li>
            </ul>
            <?php wp_nav_menu([
              'theme_location' => 'primary',
              'menu_class' => 'nav-menu',
            ]); ?>
          </nav>

          
          <?php if ( have_rows( 'card_list', 'options' ) ) : ?>
            <ul class="footer__cards">
              <?php while ( have_rows( 'card_list', 'options' ) ) :
                the_row(); ?>
                <li class="footer__cards-item">
                  <?php $icon = get_sub_field( 'icon', 'options' );
                  if ( $icon ) : ?>
                    <img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" />
                  <?php endif; ?>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
            

           
         
      </div>
    </div>
    <div class="footer__bottom">
        <span class="footer__descr">© Всі права захищені | 2016 - 2023</span>       
        
        <div class="footer__coll">
          <div class="social">
              <span class="footer__text">Ми в соціальних мережах</span>

              <?php if ( have_rows( 'social', 'options' ) ) : ?>

                <ul class="social__list">
                <?php while ( have_rows( 'social', 'options' ) ) : the_row(); ?>
                  <li>
                    <a href="<?php echo get_sub_field( 'link', 'options' )  ?>">
                      <?php $icon = get_sub_field( 'icon', 'options' );
                      if ( $icon ) : ?>
                        <img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" />
                      <?php endif; ?>
                    </a>
                  </li>
                <?php endwhile; ?>
                </ul>
              <?php endif; ?>

              

             
          </div>

          <span class="footer__text">
            <svg width='20' height='16'>
                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#mail'></use>
            </svg>

            <?php if ( $mail = get_field( 'mail', 'options' ) ) : ?>
              <a class="footer__link" href="mailto:<?php echo esc_html( $mail ); ?>">
                <?php echo esc_html( $mail ); ?>
              </a>
            <?php endif; ?>
          </span>

          <div class="footer__text">
            <svg width='14' height='16'>
                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#phone'></use>
            </svg>

            <div class="footer__links">
              <?php if ( have_rows( 'phone', 'options' ) ) : ?>
                <?php while ( have_rows( 'phone', 'options' ) ) : the_row(); ?>
                  <a href="tel:<?php echo get_sub_field( 'number', 'options' ) ?>" class="footer__link">
                    <?php echo get_sub_field( 'number', 'options' ) ?>
                    <?php echo get_sub_field( 'descr', 'options' ) ?>
                  </a>
                <?php endwhile; ?>
              <?php endif; ?>

              <?php if ( have_rows( 'phone_2', 'options' ) ) : ?>
                <?php while ( have_rows( 'phone_2', 'options' ) ) : the_row(); ?>
                  <a href="tel:<?php echo get_sub_field( 'number', 'options' ) ?>" class="footer__link">
                    <?php echo get_sub_field( 'number', 'options' ) ?>
                    <?php echo get_sub_field( 'descr', 'options' ) ?>
                  </a>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="footer__text">
            <svg width='14' height='16'>
                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#clock'></use>
            </svg>

            <div class="footer__links">
              <span><?php echo esc_html( get_field( 'first', 'options' ) ); ?></span>
              <span><?php echo esc_html( get_field( 'second', 'options' ) ); ?></span>
            </div>
          </div>

        </div>
    </div>
	  <!-- <?php do_action( 'twentytwelve_credits' ); ?> -->
  </div><!-- .site-info -->
</footer><!-- #colophon -->



<?php load_template(get_template_directory() . '/components/modals.php', true); ?>

<!-- <div id="fixed-call">
  <a href="#question-dialog">
    <img draggable="false" class="emoji" alt=""
      src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAACKklEQVR42mNgQAL////XAOIZQHwPiL2B+BkQ+zBQGwANZQfiSUD8+z8CBELpH0DMT03LGIF4/X9MEIrElqKmhan/sYMIJLYcEebIAPE6IOYipPAyDgujkNiKBMyQAOLrULVLCVn4G4eFMUhsVQKWXYOqew3E+oQs/InDwiRoggEBDRx6JZF8RtgyqKZXOCzMgsrNAWImLPpUkSwDgXdAfBsJ3wDi7UCcCMQsyBovYbEMpFgTiAXxOLQRiP/+Jw4cB2IRmMZNWBToEpnCk5EsvQXE/qCCAooDgLgLiL9C5feDQwpIdKBZ9ovEbIVs6TIgZkaTt0RKJ+kggWAsPtSgwNLZWOQXQeUugjiiQPwPzcJ5ZBQgIEs/ArEdFrlSqLlfYALX0CwE5U0VMiwVxSE+F2ruVZjAFCzBuphKRacBEH+HmpkPE3TDYiEoTnQosMQZiGuB+ANS1mCGKWAB4idYLN1ApoUH0cy5CCqV0BWV4ci0VmRa+AdagFQBMQc2RVzQmh4dHAXVmQy0AECDHXEUV5FY1CoBcR0Qq1FqaR8WC18gxwGQLYtU6IOKrgRK2zdnsFj6ElS5AvE5IN4MxGagfIUkPwukl1xLFfBUWzAAqoKsgHgNktgpUC1DrqUgw74RsPQLtClSAU2V4JCgJHjdkKoXfKAf2o59C8TzKU1EVtBEQwgcAmJzQg0uYi0FNZRWY6lVYOAutEnCSot8ug9am/yDFgqR6JUuPgAAy+tMgj9WZZ0AAAAASUVORK5CYII=">
    </a>
</div>
<div id="question-dialog" class="modal-dialog">
  <div>
    <a href="#close" title="Close" class="modal-dialog-close">&times;</a>
	  <?php
	  echo do_shortcode( '[contact-form-7 id="7145" title="QF1"]' ); ?>
  </div>
</div> -->


<link rel="stylesheet" type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<script type="text/javascript"
        src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<?php
wp_footer(); ?>
<!-- <script>
  jQuery(document).ready(function($) {
    $('#mobile-menu-button').click(function() {
      $('#mobile-menu').slideToggle('fast');
    });
    $('#mobile-category-button').click(function() {
      $('#secondary').slideToggle('fast');
    });
    $('#mobile-search-button').click(function() {
      $('#mobile-search').slideToggle('fast');
    });
    $('#mobile-phone-button').click(function() {
      $('#mobile-phone').slideToggle('fast');
    });
  });

</script> -->
<script>
  (function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
      (i[r].q = i[r].q || []).push(arguments);
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m);
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-88429358-1', 'auto');
  ga('send', 'pageview');







  const hiddenContent = document.querySelector('.woocommerce-product-details__short-description-content');

  document.querySelector('#moreButton').addEventListener('click', function() {
    hiddenContent.classList.toggle('show');
  });

</script>
</body>
</html>