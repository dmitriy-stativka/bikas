<?php  
$build_folder = get_template_directory_uri() . '/assets/build/' ?>

<ul class="category-list">
<?php for ($catindex = 1; $catindex < 11; $catindex++) {
    $termId = get_field('id_category_' . $catindex);
    if ($term = get_term_by('id', $termId, 'product_cat')) { ?>
        <li class="category-list__item">
            <?php
            echo '<a class="category-list__link" href="' . get_term_link((int)$termId, 'product_cat') . '">';
            $thumbnail_id = get_term_meta($termId, 'thumbnail_id', true);
            //$image = wp_get_attachment_url( $thumbnail_id );
            //echo '<img src="'.$image.'" alt="'.$term->name.'" width="280" height="280" />';
            $image_attributes = wp_get_attachment_image_src($thumbnail_id, 'medium');
            if ($image_attributes) { ?>
                <img src="<?php
                echo $image_attributes[0]; ?>" width="<?php
                echo $image_attributes[1]; ?>"
                        height="<?php
                        echo $image_attributes[2]; ?>"/>
                <?php
            }
            echo '<div class="category-list__wrapper"><h2 class="category-list__title">' . $term->name . '</h2></div></a>';
            ?>
        </li>
        <?php
    } ?>
    <?php
} ?>

<li class="category-list__item all">
    <a class="category-list__link" href="#">
        <span>
        Перейти 
        до каталогу
        </span>

        <svg width='100' height='100'>
            <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-link'></use>
        </svg>
    </a>
</li>
</ul>
