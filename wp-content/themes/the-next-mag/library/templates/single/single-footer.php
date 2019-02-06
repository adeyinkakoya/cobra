<?php
$postID = get_the_ID();
?>
<footer class="single-footer entry-footer">
	<div class="entry-info">
		<div class="row row--space-between grid-gutter-10">
			<div class="entry-categories col-sm-6">
				<ul>
					<li class="entry-categories__icon"><i class="mdicon mdicon-folder"></i><span class="sr-only">Posted in</span></li>
                    <?php 
                        $catClass = 'entry-cat cat-theme';                                
                        $category = get_the_category($postID); 
                        if(isset($category[0]) && $category[0]){
                            foreach ($category as $key => $value) {
                                echo '<li><a class="cat-'.$value->term_id.' '.$catClass.'" href="'.get_category_link($value->term_id ).'">'.$value->cat_name.'</a></li>';  
                            }
                        }
                    ?>
				</ul>
			</div>
			<div class="entry-tags col-sm-6">
				<ul>
                    <?php
                    $tags = get_the_tags();
                    if($tags != '') :
                    ?>
                    <li class="entry-tags__icon"><i class="mdicon mdicon-local_offer"></i><span class="sr-only">Tagged with</span></li>
                    <?php
                        foreach ($tags as $tag):
                			echo '<li><a class="post-tag" rel="tag" href="'. get_tag_link($tag->term_id) .'">'. $tag->name.'</a></li>';
                		endforeach;
                    ?>
                    <?php endif;?>
				</ul>
			</div>
		</div>
	</div>

	<?php
        if ( function_exists( 'tnm_extension_single_entry_interaction' ) ) {
            echo tnm_extension_single_entry_interaction(get_the_ID());
        }
    ?>
</footer>