<?php get_header(); $count = 0;?>
	<div class="group container mtb40">
		<div class="row">
			<div class="span12">
				<ul class="filter clearfix">  
					<li><strong class="vt_proj_type theme_color_color" >Type:</strong></li>  
					<li class="active"><a href="javascript:void(0)" class="all">All</a></li>
					<?php echo vt_portfolio_term_list(); ?>
				</ul>  
			</div>
			<div class="span12">
				<h2 id="vt_port_header" >Portfolio of Work</h2>  
			</div>   
			<div class="span12" id="port_id_div">   
				<div id="port_group_container<?php echo vt_get_port_group_container_class(); ?>">   
					<div id="port_group" class="port_group row">   
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>  
							<?php
								$title= str_ireplace('"', '', trim(get_the_title()));  
								$desc= str_ireplace('"', '', trim(get_the_content()));  
								
							?>     
						  <?php $vt_terms = get_the_terms( $post->ID, 'project-type');?>
							<div class="port_item <?php echo vt_get_portfolio_item_class(); ?>" data-id="id-<?php echo $count++; ?>" data-type="<?php foreach ($vt_terms as $term) { echo  $term->slug . ' '; } ?>">  
								<div class="port_img">
									<a class="vt_img_cover<?php echo vt_get_port_group_container_class(); ?> vt_img_cover" rel="prettyPhoto" href="<?php print  portfolio_thumbnail_url($post->ID) ?>">
									</a>
										<a href="<?php print  portfolio_thumbnail_url($post->ID) ?>" rel="prettyPhoto" ><img class="vt_mg" src="<?php bloginfo("template_url"); ?>/images/mgWhite.png" alt="mg icon"/></a>
									<a href="<?php print  portfolio_thumbnail_url($post->ID) ?>" rel="prettyPhoto">
										<?php the_post_thumbnail(vt_get_portfolio_thumbnail_size()); ?>
									</a>
								</div>  
								<div class="port_desc">  
									<div>
										<h4><a class ="vt_portfolio_item_title" title="<?php echo $title?>" href="<?php the_permalink(); ?>"><?php echo $title?>:</a></h4>
										<a class ="vt_portfolio_exerpt" title="<?php echo $title?>" href="<?php the_permalink(); ?>"><?php echo mb_substr(get_the_excerpt(), 0, 20)."..."; ?></a>
									</div>  
								</div>  
							</div>  
						<?php endwhile; endif; ?>  
					</div>
				</div>
				<?php if (vt_use_pagination('portfolio')):?>
					<div class="pagination_numbers">
						<?php echo vt_get_pagination_numbers(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div> 
		<div class="push"></div>
	</div>  
</div>  
<?php get_footer(); ?>  