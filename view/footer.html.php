<?php

use Goteo\Library\Text,
    Goteo\Model\Category,
    Goteo\Model\Post,  // esto son entradas en portada o en footer
    Goteo\Model\Sponsor;

if (NODE_ID != GOTEO_NODE) {
    include 'view/node/footer.html.php';
    return;
}

$lang = (LANG != 'es') ? '?lang='.LANG : '';

$categories = Category::getList();  // categorias que se usan en proyectos
$posts      = Post::getList('footer');
$sponsors   = Sponsor::getList();
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.scroll-pane').jScrollPane({showArrows: true});
});
</script>

    <div id="footer" style="height:auto;">
        <?php if($bannerPrensa) {?>
        <div style="background-color:#cdcdcd; height:150px;">
            <?php echo $bannerPrensa;?> 
        </div> 
        <?php }?>
		<div class="w940">
        	<div class="block categories">
                <h8 class="title"><?php echo Text::get('footer-header-categories') ?></h8>
                <ul class="scroll-pane">
                <?php foreach ($categories as $id=>$name) : ?>
                    <li><a href="/discover/results/<?php echo $id.'/'.$name; ?>"><?php echo $name; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>

            <div class="block projects">
                <h8 class="title"><?php echo Text::get('footer-header-projects') ?></h8>
                <ul class="scroll-pane">
                    <li><a href="/"><?php echo Text::get('home-promotes-header') ?></a></li>
                    <li><a href="/discover/view/popular"><?php echo Text::get('discover-group-popular-header') ?></a></li>
                    <li><a href="/discover/view/outdate"><?php echo Text::get('discover-group-outdate-header') ?></a></li>
                    <li><a href="/discover/view/recent"><?php echo Text::get('discover-group-recent-header') ?></a></li>
                    <li><a href="/discover/view/success"><?php echo Text::get('discover-group-success-header') ?></a></li>
                    <li><a href="/discover/view/archive"><?php echo Text::get('discover-group-archive-header') ?></a></li>
                    <li><a href="/project/create"><?php echo Text::get('regular-create') ?></a></li>
                </ul>
            </div>

            <div class="block resources">
                <h8 class="title"><?php echo Text::get('footer-header-resources') ?></h8>
                <ul class="scroll-pane">
                    <li><a href="/faq"><?php echo Text::get('regular-header-faq') ?></a></li>
                    <li><a href="/glossary"><?php echo Text::get('footer-resources-glossary') ?></a></li>
                    <li><a href="/press"><?php echo Text::get('footer-resources-press') ?></a></li>
                    <?php foreach ($posts as $id=>$title) : ?>
                    <li><a href="/blog/<?php echo $id ?>"><?php echo Text::recorta($title, 50) ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="/newsletter" target="_blank">Newsletter</a></li>
                    <li><a href="https://github.com/Goteo/Goteo" target="_blank"><?php echo Text::get('footer-resources-source_code') ?></a></li>
                </ul>
            </div>
			<script type="text/javascript">
				$(function(){
					$('#slides_sponsor').slides({
						container: 'slides_container',
						effect: 'fade', 
						crossfade: false,
						fadeSpeed: 350,
						play: 5000, 
						pause: 1
					});
				});
			</script>
           <div id="slides_sponsor" class="block sponsors">
                <h8 class="title"><?php echo Text::get('footer-header-sponsors') ?></h8>
				<div class="slides_container">
					<?php $i = 1; foreach ($sponsors as $sponsor) : ?>
					<div class="sponsor" id="footer-sponsor-<?php echo $i ?>">
						<a href="<?php echo $sponsor->url ?>" title="<?php echo $sponsor->name ?>" target="_blank" rel="nofollow"><img src="<?php echo $sponsor->image->getLink(150, 85) ?>" alt="<?php echo $sponsor->name ?>" /></a>
					</div>
					<?php $i++; endforeach; ?>
				</div>
				<div class="slidersponsors-ctrl">
					<a class="prev">prev</a>
					<ul class="paginacion"></ul>
					<a class="next">next</a>
				</div>
            </div>

            <div class="block services">
                
                <h8 class="title"><?php echo Text::get('footer-header-services') ?></h8>
                <ul>
                    <li><a href="/service/resources"><?php echo Text::get('footer-service-resources') ?></a></li>
<?php /*                    <li><a href="/service/campaign"><?php echo Text::get('footer-service-campaign') ?></a></li>
                    <li><a href="/service/consulting"><?php echo Text::get('footer-service-consulting') ?></a></li>
 *
 */ ?>
                    <li><a href="/service/workshop"><?php echo Text::get('footer-service-workshop') ?></a></li>
                </ul>
                
            </div>
         
            <div class="block social" style="border-right:#ebe9ea 2px solid;">
                <h8 class="title"><?php echo Text::get('footer-header-social') ?></h8>
                <ul>
                    <li class="twitter"><a href="<?php echo Text::get('social-account-twitter') ?>" target="_blank"><?php echo Text::get('regular-twitter') ?></a></li>
                    <li class="facebook"><a href="<?php echo Text::get('social-account-facebook') ?>" target="_blank"><?php echo Text::get('regular-facebook') ?></a></li>
                    <li class="identica"><a href="<?php echo Text::get('social-account-identica') ?>" target="_blank"><?php echo Text::get('regular-identica') ?></a></li>
                    <li class="gplus"><a href="<?php echo Text::get('social-account-google') ?>" target="_blank"><?php echo Text::get('regular-google') ?></a></li>
                    <li class="rss"><a rel="alternate" type="application/rss+xml" title="RSS" href="/rss<?php echo $lang ?>" target="_blank"><?php echo Text::get('regular-share-rss'); ?></a></li>

                </ul>
            </div>

		</div>
    </div>

    <div id="sub-footer">
		<div class="w940">
		
           
                
                <ul>
                    <li><a href="/about"><?php echo Text::get('regular-header-about'); ?></a></li>
                    <li><a href="/user/login"><?php echo Text::get('regular-login'); ?></a></li>
                    <li><a href="/contact"><?php echo Text::get('regular-footer-contact'); ?></a></li>
<!--                    <li><a href="/blog"><?php echo Text::get('regular-header-blog'); ?></a></li> -->
<!--                    <li><a href="/about/legal"><?php echo Text::get('regular-footer-legal'); ?></a></li> -->
                    <li><a href="/legal/terms"><?php echo Text::get('regular-footer-terms'); ?></a></li>
                    <li><a href="/legal/privacy"><?php echo Text::get('regular-footer-privacy'); ?></a></li>
                </ul>
    
                <div class="platoniq">
                   <span class="text"><a href="#" class="poweredby"><?php echo Text::get('footer-platoniq-iniciative') ?></a></span>
                   <span class="logo"><a href="http://fuentesabiertas.org" target="_blank" class="foundation">FFA</a></span>
                   <span class="logo"><a href="http://www.youcoop.org" target="_blank" class="growby">Platoniq</a></span>
                </div>
    
       
        </div>

    </div>