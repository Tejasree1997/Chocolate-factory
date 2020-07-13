
<?php 
$page_title= 'Home';
require_once('views/page_top.php');
require_once('database/products.php');

?>
<section>
            <input type="radio" id="s-1" name="slider-control" checked="checked">
            <input type="radio" id="s-2" name="slider-control">
            <input type="radio" id="s-3" name="slider-control">

            <div class="js-slider">
              
              <figure class="js-slider_item img-1">
                  
                  <div class="js-slider_img">
                    <img class="c-img-w-full" src="images/carosoul1.png" alt="">
                  </div>
              
              </figure>
  
              <figure class="js-slider_item img-2">
                
                <div class="js-slider_img">
                  <img class="c-img-h-full" src="images/carosoul2.jpg"  alt=""></div>
              
              </figure>

              <figure class="js-slider_item img-3">
                
                <div class="js-slider_img">
                  <img class="c-img-h-full" src="images/carosoul3.png"  alt=""></div>
              
              </figure>
          
              <div class="js-slider_nav">
                <label class="js-slider_nav_item s-nav-1 prev" for="s-3"></label>
                <label class="js-slider_nav_item s-nav-1 next" for="s-2"></label>
                <label class="js-slider_nav_item s-nav-2 prev" for="s-1"></label>
                <label class="js-slider_nav_item s-nav-2 next" for="s-3"></label>
                <label class="js-slider_nav_item s-nav-3 prev" for="s-2"></label>
                <label class="js-slider_nav_item s-nav-3 next" for="s-1"></label>
              </div>
  
              <div class="js-slider_indicator">
                <div class="js-slider-indi indi-1"></div>
                <div class="js-slider-indi indi-2"></div>
                <div class="js-slider-indi indi-3"></div>
              </div>
           </div>
<?php 
require_once('views/page_bottom.php');
?>