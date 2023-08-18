<section class="icons-section">
    <div class="container">
        <ul class="icons-section__list">
        <?php if ( have_rows( 'icons_block' ) ) : ?>
            <?php while ( have_rows( 'icons_block' ) ) :
                the_row(); ?>
                    <li class="icons-section__item">
                        <?php $icon = get_sub_field( 'icon' );
                        if ( $icon ) : ?>
                            <div class="icons-section__icon">
                                <img src="<?php echo esc_url( $icon['url'] ); ?>"
                                alt="<?php echo esc_attr( $icon['alt'] ); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if ( $text = get_sub_field( 'text' ) ) : ?>
                        <p> <?php echo esc_html( $text ); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
    </div>
</section>