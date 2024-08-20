<?php
   /**
    * Template Name: Custom Home Page
    */
   
   get_header(); 
   
   
   if ( ! defined( 'ABSPATH' ) ) {
    exit; 
   }
   
   use Elementor\Plugin;
   

   echo do_shortcode('[smartslider3 slider="3"]');
   ?>
<scrolling-promotion data-speed="2.5" class="scrolling-promotion scrolling-promotion--left section--padding promotion-icon--colored" style="--duration: 16.8s; background: #000;">
   <div class="promotion promotion--animated">
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-1 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/1Damac-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--medium" style="background: {{ block.settings.box-color-2 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/1AP-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-3 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/Patek-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
   </div>
   <div class="promotion promotion--animated">
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-1 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/Rolex-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--medium" style="background: {{ block.settings.box-color-2 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/RR-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-3 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/Damac-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
   </div>
   <div class="promotion promotion--animated">
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-1 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/1Damac-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--medium" style="background: {{ block.settings.box-color-2 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/1AP-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
      <div class="promotion__item promotion-icon--small" style="background: {{ block.settings.box-color-3 }}">
         <div class="promotion__text heading" style="--font-size: 16px;">
            <div class="custom-banner-logo-image-wrap" style="width: 100%;height: 80px; display: flex; align-items: center;">
               <img src="https://win.boo/wp-content/uploads/2024/07/Rolex-Logo.png" style="width: 100%; object-fit: none; height: 100%;">
            </div>
         </div>
      </div>
   </div>
</scrolling-promotion>
<!-- 	 <div class="sold-out-container">
   <div class="progress-bar">
       <div class="progress-bar-fill" style="width: 0%;"></div>
   </div>
   <div class="sold-out-text">
     <img src="https://win.boo/wp-content/uploads/2024/07/ticket-removebg-preview1.png" style="width: 23px; position: relative;top: -2px;"> <span id="sold-percentage">0%</span>  Tickets Sold Out
   </div>
   </div> -->

   
<?php
   // Query to get the latest 3 products
   $args = array(
       'post_type' => 'product',
       'posts_per_page' => 3,
       'meta_key' => '_draw_date', // Assuming you have a draw date meta key
       'orderby' => 'meta_value',
       'order' => 'ASC',
   );
   
   $products = new WP_Query($args);
   
   if ($products->have_posts()) :
   ?>
<div class="Custom-Rolex-Main top_product_section">
   <div class="Custom-Rolex-Inner Page-Width">
      <div class="Custom-Rolex-Boxes">
         <?php while ($products->have_posts()) : $products->the_post(); ?>
         <?php
            global $product;
            
            $entry_price = $product->get_price();
            $original_price = get_post_meta($product->get_id(), '_original_price', true);
            if (!is_numeric($original_price)) {
                $original_price = 0.00;
            } else {
                $original_price = floatval($original_price);
            }
            $currency_symbol = get_woocommerce_currency_symbol();
            $stock_quantity = $product->get_stock_quantity(); // Get the stock quantity
            
            $main_image_url = get_the_post_thumbnail_url($product->get_id(), 'large');
            
            $draw_date = get_post_meta($product->get_id(), '_draw_date', true);
            
            
              if (preg_match('/(\d{2})-(\d{2})-(\d{4})/', $draw_date, $matches)) {
                 $draw_date_formatted = $matches[3] . '-' . $matches[1] . '-' . $matches[2]; 
                 $draw_date_timestamp = strtotime($draw_date_formatted);
              } else {
                 $draw_date_timestamp = false; 
              }
            
              if ($draw_date_timestamp) {
                 $draw_day = date('D j M', $draw_date_timestamp); 
              } else {
                 $draw_day = 'Invalid date'; 
              }
            
            ?>
         <div class="Custom-Rolex-Box">
            <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
            <div class="Custom-Rolex-Data">
               <div class="Custom-Rolex-Title">
                  <h3 style="color:white;"><mark style="background-color: #DAA521; color: #fff;">Draw <?php echo esc_html($draw_day); ?></mark></h3>
                  <h1><?php the_title(); ?></h1>
                  <h2><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?></h2>
               </div>
               <div class="Custom-Rolex-Count-Box">
                  <div class="Custom-Rolex-Count">
                     <div class="countdown" data-draw-date="<?php echo esc_attr($draw_date); ?>" id="countdown-<?php echo get_the_ID(); ?>">
                        <div class="countdown-item">
                           <span class="days">00</span>
                           <div class="label">DAY</div>
                        </div>
                        <div class="countdown-item">
                           <span class="hours">00</span>
                           <div class="label">HOUR</div>
                        </div>
                        <div class="countdown-item">
                           <span class="minutes">00</span>
                           <div class="label">MIN</div>
                        </div>
                        <div class="countdown-item">
                           <span class="seconds">00</span>
                           <div class="label">SEC</div>
                        </div>
                     </div>
                  </div>
                  <div class="Custom-Rolex-Count">
                     <div class="Custom-Watch-Data">
                        <div class="Custom-Watch-Data-Inner">
                           <h1>Uhren Wert</h1>
                           <p><?php echo esc_html($currency_symbol . number_format($original_price, 2)); ?></p>
                        </div>
                     </div>
                     <div class="Custom-Watch-Data">
                        <div class="Custom-Watch-Data-Inner">
                           <h1>Eintrittspreis</h1>
                           <p><?php echo esc_html($currency_symbol . number_format($entry_price, 2)); ?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="Custom-Button-Data">
                  <div class="Custom-Text-Data">
                     <h1><?php echo esc_html($stock_quantity); ?></h1>
                     <h2>MAXIMUM TICKETS</h2>
                  </div>
                  <div class="Custom-Text-Data">
                     <a href="<?php the_permalink(); ?>">Sichere dir dein Ticket →</a>
                  </div>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
         <?php wp_reset_postdata(); ?>
      </div>
   </div>
</div>
<?php endif; ?>




<div class="Custom-Background-Image Page-Width">
   <div class="Custom-Background-Image-Inner">
      <div class="Custom-Svg-Box mycustom-bg-image">
         <div class="Custom-Svg-Title">
            <div class="Custom-Svg-Title-Inner">
               <h1>
                  UNSERE ZIEL IST ES,<span>JEDEN</span> ZUM <span>GEWINNER</span>ZU MACHEN
               </h1>
            </div>
         </div>
         <div class="Custom-Svg-Title">
            <p>Wir haben Uhren im Wert von 1.395.745 € verschenkt. Weltweit Spitzenreiter für unschlagbare Gewinnchancen.</p>
         </div>
      </div>
   </div>
</div>


<div class="custom-image-width-text-main" style="margin: 20px 0px;">
   <div class="custom-image-width-text-main-wrap Page-Width">
      <div class="custom-image-width-text-main-data">
         <div class="custom-image-width-text-main-data-left">
            <div class="custom-left-image-wrap">
               <img src="https://win.boo/wp-content/uploads/2024/08/image.jpeg">
            </div>
         </div>
         <div class="custom-image-width-text-main-data-right">
            <div class="custom-right-data-wrapper">
               <h1>
                  Mit der DKMS gegen Blutkrebs
               </h1>
               <p>
                  Gutes Tun kann echt einfach sein: Die Traumhausverlosung ist eine Soziallotterie. Das bedeutet: Pro Los geht anteilig ein Betrag an die DKMS, eine lebensrettende Organisation, die sich weltweit dafür einsetzt, Menschen, die an Blutkrebs erkrankt sind, eine zweite Chance auf Leben zu geben. Die DKMS (früher Deutsche Knochenmarkspenderdatei) ist eine gemeinnützige Organisation, die sich weltweit dafür einsetzt, Menschen, die an Blutkrebs erkrankt sind, eine zweite Chance auf Leben zu geben.
               </p>
            </div>
         </div>
      </div>
   </div>
</div>



<div class="text Page-Width">
   <div class="slide-flexxx" style="width: 100%; margin: 0 auto;">
      <div class="container">
         <?php
            $args = array(
               'post_type'      => 'winner',
               'posts_per_page' => -1, 
            );
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
               while ($query->have_posts()) {
                  $query->the_post();
                  
                  // Get custom fields
                  $image = get_post_meta(get_the_ID(), 'winner_image', true);
                  $price = get_post_meta(get_the_ID(), 'watch_price', true);
                  $details = get_post_meta(get_the_ID(), 'winner_details', true);
            ?>
         <div class="slide">
            <div class="custom-slider-wraper">
               <div class="slide-aaaaa">
                  <img src="<?php echo esc_url($image); ?>" alt="Winner">
               </div>
               <div class="slide-aaaaa-text">
                  <div class="pahla-flex" style="display: flex; padding: 20px;">
                     <div class="flex flex-col justify-center">
                        <span class="text-xl text-white" style="font-size: 1.25rem; line-height: 1.75rem; color: white;"><?php echo esc_html($details); ?></span>
                        <br>
                        <span class="text-base font-medium text-stone-200"><?php echo esc_html(get_the_title()); ?></span>
                     </div>
                     <div class="flex flex-col justify-center">
                        <span class="text-xl font-medium text-stone-200"><?php echo esc_html($price); ?></span>
                        <span class="text-stone-200">Value</span>
                     </div>
                  </div>
                  <div class="qqqq" style="background: black; padding: 20px; display: flex; justify-content: center; align-items: center; gap: 20px; font-weight: 700;">
                     <span class="text-xl text-white">Join the next competition</span>
                     <svg viewBox="0 0 24 24" role="image" xmlns="http://www.w3.org/2000/svg" class="mt-1 h-5 w-5">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.858 20H10.221C6.3456 20 4.40789 20 3.20394 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.20394 5.17157C4.40789 4 6.34561 4 10.221 4H12.858C15.0854 4 16.1992 4 17.1289 4.50143C18.0586 5.00286 18.6488 5.92191 19.8294 7.76001L20.5102 8.82001C21.5034 10.3664 22 11.1396 22 12C22 12.8604 21.5034 13.6336 20.5102 15.18L19.8294 16.24C18.6488 18.0781 18.0586 18.9971 17.1289 19.4986C16.1992 20 15.0854 20 12.858 20ZM7 7.05423C7.41421 7.05423 7.75 7.37026 7.75 7.76011V16.2353C7.75 16.6251 7.41421 16.9412 7 16.9412C6.58579 16.9412 6.25 16.6251 6.25 16.2353V7.76011C6.25 7.37026 6.58579 7.05423 7 7.05423Z" fill="white"></path>
                     </svg>
                  </div>
               </div>
            </div>
         </div>
         <?php
            }
            wp_reset_postdata(); // Reset post data
            }
            ?>
      </div>
   </div>
   <div class="buttons">
      <button class="previous">
         <svg xmlns="http://www.w3.org/2000/svg" width="27px" height="41px">
            <image x="0px" y="0px" width="27px" height="41px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAApCAQAAABub5p4AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfoBxoSBjdKAi0zAAAB5klEQVRIx43Wy2sTURTH8e8k0TQKJWhRWyyahU+s1GBtUUHarf4D0pUILnQjooIvCkUXgnQjEUGk4MKFIIUaqKtYQbtoqRB00WoruKoY8IFBkJheF22Sc6YzmfObzTAzH86999xhxnMAePjjxPnq3YMMkOY1k86xcgTFd+cCZf5S4Tu7HU2YymWqq49WuYJnY9fryPGPc8SimcetOnE4Fmm3VBsSlRyLHA+auE6cYVXpM0eC10vnNssCLdAbtsyNJLirKn2iJ7w7jeHdU+gjh5o1tYZGFJoj63sigCW570MH1oxmDfPIKVSkK2DmPraBBwq9Z1/gGiu2jkcKvWNvSGsES/FYoRl2hTW0wVKMKjRNBqJYC08UesMOiGDEySv0NgKBgwwXFSqwncgkuMovgfK0R6MYsIWUuPKCpWiGgywP1Yt4ysQcJJkVcJ6TtBiYg8MKlhgmaWFwjA8C/uFGUyg2Vz8LApa5RMLC4ASvBPzBeeIWBtt4JuA3ztgYbGVcwK8M2hh0UhDwC6dJWxhkmBLwJznaLAz2UBSwQo5WC4Nu1ccqI2y0MOhmQlW8I2DTb8Bmnqqdc431FgZtjKl29NkYdPBSwLNWBjuZrA/zqJ3Bfp5TYombtc3thf2X+LKJLL+ZrlX4D+vYhNmVPTwHAAAAAElFTkSuQmCC" />
         </svg>
      </button>
      <button class="view-all" style="padding: 10px 100px;">Alle Gewinner Ansehen</button>
      <button class="next">
         <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="30px" height="46px">
            <image  x="0px" y="0px" width="30px" height="46px"  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAqCAMAAABx2QBSAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB71BMVEX///8Qck8Qd1IQeFMReVQNXD8NYUMNYkQRe1QRflYOZ0cOZkYOZEUOY0QNYkMNX0ENYEIPa0oPbEoOaEgOaUkPb0wPb00OaUgNX0IOZUYNXkEZt34NY0QZt34Zt34Xo3ESgloZt34Zt34ShFoZt34Zt34Qd1IZt34QeFMZt34Zt34ReVQNXD8Zt34Zt34RelQZt34Xp3MRe1QNXD8OZ0cWoW8Re1UOZkYWoG4RflYNXD8OZEUWn24RflcOZkYWn20Rf1cOZEUSgFgNXD8OZEUVm2sSgVkOZEUVnGwSgVkNXD8OY0QVmmoSg1oNXD8NYkQVmGkShFsNXD8NYkMVl2gShVsNYkMUlWYShlwNXD8UlWcTjWENYUMNYUMUkmUTi2ANYkQNYkQNX0IPbUsPbUsQc08Pb00Pb00PbEoUkGMNYkQNYkQPa0oWn24VmWkOZ0cXqnUOZ0cQeVMVnGwOaEgQdlEOaUkQdFAYrHcUkmUOaUgPcU4XqXUTiV4NX0IPb00XqHQTjWENX0INX0EPb0wWpHENYEINYEIYrXcUlmcNX0EOY0QNXD8OZUYRe1UUj2IQeFMTiF0NXkETi2AUkGMNYUMUk2UNYkMQeVMXp3MTi18OZEUOaUkNXkEZt34Ztn0Ztn4YsXoYr3kZtHz///8wwaENAAAAnnRSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABMgUu+LImvL9E9bU2uh7jvQIIe78R/MIGYvrEX/rICFn6y1r5zVDRDlL300v31BRK9tgKRfTZEj702zrx3RDy6TI17uMkAzCAKqSQMYHsOASA+fVk/V27+Gixcaj+726d/eMulv3oLB+T+zcm/vIbSBZXxeu54CXm6zHvPLz95U12IyoaMBIAAAABYktHRACIBR1IAAAAB3RJTUUH6AcaETgx4OItIgAAAXpJREFUOMtt0VVXAmEQBuA1AF3WFcVCxW4xMbFFsVuxuxu7uxW7azH+qPCNtcPO7XPeORMU5eNrY2trZy/ilVgioZR+/gFKQQkM4rhgQQkJ5ThTmJCEm4UzRQhIZBRnqWiVlcTEEjHFOWCh4hMIcYlqLFRSMpG3FEcsdGoapNI1WKQZmUBZaixMdg5QrhqLNO+b8rVYmIJCIJ0KC1NUDFRSioUpKweqqMTiVFUNVFOLRVJXD9RQi4XVNwI1NWNh9S1ArW1Y2PYOoM6ubiTinlZ4Sm+fWUQiZ5nz91VcXPshNDCIZQheMjwyypfmsXECE5Nkgj/RJhoApmi+aKffCczM0rQFfkUz90EgeV5O8zLqhUUCS8tu8v8Zd4+VVQJr655INjYJbG17gfx029ndI9Cx78WXA90hgaM6GV+OdZ8ECk9YvhhzTbDHqRNfjGeQOD9VILmAzS+vFFhg3OsDbyshcHMrsxZLs7t7sYA8PBqenlkhUSW9vDLW8gWywc/FxmAZGwAAAABJRU5ErkJggg==" />
         </svg>
      </button>
   </div>
</div>


<div class="Custom-Svg-Main Page-Width">
   <div class="Custom-Svg-Inner">
      <div class="Custom-Svg-Box custom-static-text">
         <div class="Custom-Svg-Title">
            <div class="Custom-Svg-Title-Inner" custom-title2nd>
               <h1>
                  <span>WIE</span> NEHME ICH AM
                  GEWINNSPIEL <span>TEIL?</span>
               </h1>
            </div>
         </div>
         <div class="Custom-Svg-Title custom-title2nd">
            <p>Erhalte die Chance, das nächsten Gewinnspiel zu gewinnen um deine Traumuhr zu erhalten</p>
         </div>
      </div>
      <div class="Custom-Svg-Boxes mycustom-icons-boxes">
         <div class="Custom-Svg-Box1">
            <div class="main-custom-container-pro">
               <div class="circle-container">
                  <div class="circle circle-1">
                     <div class="svg-box mycustom1">
                        <svg role="image" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px] fill-white">
                           <path d="M27.4999 10.2029L27.4999 10.2936C27.4999 11.3695 27.4999 11.9075 27.2409 12.3476C26.9819 12.7878 26.5116 13.049 25.5711 13.5716L24.5795 14.1225C25.2628 11.8123 25.4908 9.33018 25.5751 7.20747C25.5787 7.11645 25.5828 7.02432 25.5869 6.93121L25.5897 6.86599C26.4038 7.1487 26.8609 7.35947 27.1461 7.7551C27.5 8.24616 27.5 8.89841 27.4999 10.2029Z" fill="white"></path>
                           <path d="M2.5 10.2029L2.5 10.2936C2.50003 11.3695 2.50005 11.9075 2.75903 12.3476C3.01802 12.7878 3.48829 13.049 4.42881 13.5716L5.42101 14.1228C4.73759 11.8125 4.50959 9.33027 4.42531 7.20747C4.4217 7.11645 4.41763 7.02432 4.41351 6.93121L4.41063 6.86583C3.59626 7.14862 3.13907 7.3594 2.85387 7.7551C2.49995 8.24616 2.49997 8.89842 2.5 10.2029Z" fill="white"></path>
                           <path fill-rule="evenodd" clip-rule="evenodd" d="M20.4714 2.93343C19.0663 2.69636 17.2296 2.5 15.0002 2.5C12.7708 2.5 10.9341 2.69636 9.52897 2.93343C8.10556 3.17359 7.39385 3.29367 6.79921 4.02604C6.20456 4.75841 6.23599 5.54997 6.29884 7.13309C6.51461 12.568 7.68745 19.3563 14.0625 19.9571V24.375H12.2748C11.6789 24.375 11.1659 24.7956 11.049 25.3799L10.8125 26.5625H7.5C6.98223 26.5625 6.5625 26.9822 6.5625 27.5C6.5625 28.0178 6.98223 28.4375 7.5 28.4375H22.5C23.0178 28.4375 23.4375 28.0178 23.4375 27.5C23.4375 26.9822 23.0178 26.5625 22.5 26.5625H19.1875L18.951 25.3799C18.8341 24.7956 18.3211 24.375 17.7252 24.375H15.9375V19.9571C22.3129 19.3566 23.4858 12.5681 23.7015 7.13309C23.7644 5.54997 23.7958 4.75841 23.2012 4.02604C22.6065 3.29367 21.8948 3.17359 20.4714 2.93343Z" fill="white"></path>
                        </svg>
                     </div>
                  </div>
               </div>
               <p class="mycustom1">AUSWÄHLEN</p>
               <div class="svg-line">
                  <svg role="image" viewBox="0 0 246 10" xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
                     <svg role="image" viewBox="0 0 246 10" xmlns="http://www.w3.org/2000/svg" class=" h-full w-full">
                        <line x1="0.5" y1="3" x2="0.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="5.5" y1="3" x2="5.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="10.5" y1="3" x2="10.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="15.5" y1="3" x2="15.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="20.5" y1="-2.18557e-08" x2="20.5" y2="10" stroke="#DAA521"></line>
                        <line x1="25.5" y1="3" x2="25.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="30.5" y1="3" x2="30.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="35.5" y1="3" x2="35.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="40.5" y1="3" x2="40.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="45.5" y1="-2.18557e-08" x2="45.5" y2="10" stroke="#DAA521"></line>
                        <line x1="50.5" y1="3" x2="50.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="55.5" y1="3" x2="55.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="60.5" y1="3" x2="60.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="65.5" y1="3" x2="65.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="70.5" y1="-2.18557e-08" x2="70.5" y2="10" stroke="#DAA521"></line>
                        <line x1="75.5" y1="3" x2="75.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="80.5" y1="3" x2="80.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="85.5" y1="3" x2="85.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="90.5" y1="3" x2="90.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="95.5" y1="-2.18557e-08" x2="95.5" y2="10" stroke="#DAA521"></line>
                        <line x1="100.5" y1="3" x2="100.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="105.5" y1="3" x2="105.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="110.5" y1="3" x2="110.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="115.5" y1="3" x2="115.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="120.5" y1="-2.18557e-08" x2="120.5" y2="10" stroke="#DAA521"></line>
                        <line x1="125.5" y1="3" x2="125.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="130.5" y1="3" x2="130.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="135.5" y1="3" x2="135.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="140.5" y1="3" x2="140.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="145.5" y1="-2.18557e-08" x2="145.5" y2="10" stroke="#DAA521"></line>
                        <line x1="150.5" y1="3" x2="150.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="155.5" y1="3" x2="155.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="160.5" y1="3" x2="160.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="165.5" y1="3" x2="165.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="170.5" y1="-2.18557e-08" x2="170.5" y2="10" stroke="#DAA521"></line>
                        <line x1="175.5" y1="3" x2="175.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="180.5" y1="3" x2="180.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="185.5" y1="3" x2="185.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="190.5" y1="3" x2="190.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="195.5" y1="-2.18557e-08" x2="195.5" y2="10" stroke="#DAA521"></line>
                        <line x1="200.5" y1="3" x2="200.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="205.5" y1="3" x2="205.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="210.5" y1="3" x2="210.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="215.5" y1="3" x2="215.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="220.5" y1="-2.18557e-08" x2="220.5" y2="10" stroke="#DAA521"></line>
                        <line x1="225.5" y1="3" x2="225.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="230.5" y1="3" x2="230.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="235.5" y1="3" x2="235.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="240.5" y1="3" x2="240.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="245.5" y1="-2.18557e-08" x2="245.5" y2="10" stroke="#DAA521"></line>
                     </svg>
                  </svg>
               </div>
               <div class="custom-second-icon">
                  <div class="circle circle-3">
                     <div class="svg-box">
                        <svg role="image" viewBox="0 0 18 21" xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]">
                           <path fill-rule="evenodd" clip-rule="evenodd" d="M5.56323 5.51371C5.56314 5.50917 5.5631 5.50462 5.5631 5.50006V4.58339C5.5631 2.68491 7.10212 0 9.0006 0C10.8991 0 12.4381 2.68491 12.4381 4.58339V5.50006C12.4381 5.50462 12.4381 5.50917 12.438 5.51371C13.6179 5.54913 14.34 5.67642 14.8912 6.13391C15.655 6.76776 15.8561 7.84066 16.2585 9.98647L16.946 13.6531C17.5117 16.6705 17.7946 18.1792 16.9699 19.173C16.1451 20.1667 14.6101 20.1667 11.5402 20.1667H6.46102C3.39105 20.1667 1.85607 20.1667 1.03133 19.173C0.206586 18.1792 0.489466 16.6705 1.05523 13.6531L1.74273 9.98647C2.14507 7.84066 2.34624 6.76776 3.10998 6.13391C3.66122 5.67642 4.38325 5.54913 5.56323 5.51371ZM6.9381 4.58339C6.9381 3.4443 7.86151 1.375 9.0006 1.375C10.1397 1.375 11.0631 3.4443 11.0631 4.58339V5.50006C10.9941 5.50003 10.924 5.50006 10.8527 5.50006H7.14852C7.07723 5.50006 7.00709 5.50006 6.9381 5.50008V4.58339Z" fill="current"></path>
                        </svg>
                     </div>
                  </div>
               </div>
               <p class="mycustom2">SPIELEN</p>
               <div class="svg-line">
                  <svg role="image" viewBox="0 0 246 10" xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
                     <svg role="image" viewBox="0 0 246 10" xmlns="http://www.w3.org/2000/svg" class=" h-full w-full">
                        <line x1="0.5" y1="3" x2="0.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="5.5" y1="3" x2="5.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="10.5" y1="3" x2="10.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="15.5" y1="3" x2="15.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="20.5" y1="-2.18557e-08" x2="20.5" y2="10" stroke="#DAA521"></line>
                        <line x1="25.5" y1="3" x2="25.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="30.5" y1="3" x2="30.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="35.5" y1="3" x2="35.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="40.5" y1="3" x2="40.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="45.5" y1="-2.18557e-08" x2="45.5" y2="10" stroke="#DAA521"></line>
                        <line x1="50.5" y1="3" x2="50.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="55.5" y1="3" x2="55.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="60.5" y1="3" x2="60.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="65.5" y1="3" x2="65.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="70.5" y1="-2.18557e-08" x2="70.5" y2="10" stroke="#DAA521"></line>
                        <line x1="75.5" y1="3" x2="75.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="80.5" y1="3" x2="80.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="85.5" y1="3" x2="85.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="90.5" y1="3" x2="90.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="95.5" y1="-2.18557e-08" x2="95.5" y2="10" stroke="#DAA521"></line>
                        <line x1="100.5" y1="3" x2="100.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="105.5" y1="3" x2="105.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="110.5" y1="3" x2="110.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="115.5" y1="3" x2="115.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="120.5" y1="-2.18557e-08" x2="120.5" y2="10" stroke="#DAA521"></line>
                        <line x1="125.5" y1="3" x2="125.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="130.5" y1="3" x2="130.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="135.5" y1="3" x2="135.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="140.5" y1="3" x2="140.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="145.5" y1="-2.18557e-08" x2="145.5" y2="10" stroke="#DAA521"></line>
                        <line x1="150.5" y1="3" x2="150.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="155.5" y1="3" x2="155.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="160.5" y1="3" x2="160.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="165.5" y1="3" x2="165.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="170.5" y1="-2.18557e-08" x2="170.5" y2="10" stroke="#DAA521"></line>
                        <line x1="175.5" y1="3" x2="175.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="180.5" y1="3" x2="180.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="185.5" y1="3" x2="185.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="190.5" y1="3" x2="190.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="195.5" y1="-2.18557e-08" x2="195.5" y2="10" stroke="#DAA521"></line>
                        <line x1="200.5" y1="3" x2="200.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="205.5" y1="3" x2="205.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="210.5" y1="3" x2="210.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="215.5" y1="3" x2="215.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="220.5" y1="-2.18557e-08" x2="220.5" y2="10" stroke="#DAA521"></line>
                        <line x1="225.5" y1="3" x2="225.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="230.5" y1="3" x2="230.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="235.5" y1="3" x2="235.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="240.5" y1="3" x2="240.5" y2="10" stroke="#DBE5E0"></line>
                        <line x1="245.5" y1="-2.18557e-08" x2="245.5" y2="10" stroke="#DAA521"></line>
                     </svg>
                  </svg>
               </div>
               <div class="custom-third-icon">
                  <div class="circle circle-4">
                     <div class="svg-box">
                        <svg role="image" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]">
                           <path d="M7.82492 26.7355H7.5C6.32149 26.7355 5.73223 26.7355 5.36612 26.3694C5 26.0032 5 25.414 5 24.2355V22.8456C5 22.1974 5 21.8733 5.16647 21.5839C5.33295 21.2945 5.58409 21.1485 6.08638 20.8563C9.39322 18.933 14.0894 17.8504 17.2238 19.7199C17.4344 19.8455 17.6238 19.9971 17.7857 20.1789C18.4833 20.9625 18.4324 22.1451 17.6284 22.8469C17.4587 22.9951 17.2777 23.1074 17.0954 23.1465C17.2452 23.1291 17.3888 23.1092 17.5257 23.0874C18.665 22.9057 19.6213 22.2969 20.4968 21.6355L22.7558 19.9291C23.5521 19.3275 24.7341 19.3274 25.5307 19.9288C26.2477 20.4702 26.467 21.3618 26.0137 22.0884C25.485 22.9359 24.7401 24.02 24.0249 24.6824C23.3087 25.3458 22.2424 25.938 21.3718 26.3582C20.4076 26.8236 19.3422 27.0918 18.2587 27.2672C16.0611 27.6229 13.7707 27.5686 11.5954 27.1205C10.3657 26.8671 9.08849 26.7355 7.82492 26.7355Z" fill="white"></path>
                           <path d="M13.5766 4.20419C14.2099 3.06806 14.5266 2.5 15 2.5C15.4734 2.5 15.7901 3.06806 16.4234 4.20419L16.5873 4.49812C16.7672 4.82097 16.8572 4.98239 16.9975 5.0889C17.1378 5.19541 17.3126 5.23495 17.6621 5.31402L17.9802 5.38601C19.2101 5.66428 19.825 5.80341 19.9713 6.27387C20.1176 6.74432 19.6984 7.23454 18.86 8.21496L18.643 8.46861C18.4048 8.74722 18.2857 8.88652 18.2321 9.05886C18.1785 9.2312 18.1965 9.41706 18.2325 9.78878L18.2653 10.1272C18.3921 11.4353 18.4554 12.0894 18.0724 12.3801C17.6894 12.6709 17.1137 12.4058 15.9622 11.8756L15.6643 11.7384C15.337 11.5878 15.1734 11.5124 15 11.5124C14.8266 11.5124 14.663 11.5878 14.3357 11.7384L14.0378 11.8756C12.8863 12.4058 12.3106 12.6709 11.9276 12.3801C11.5446 12.0894 11.6079 11.4353 11.7347 10.1272L11.7675 9.78878C11.8035 9.41706 11.8215 9.2312 11.7679 9.05886C11.7143 8.88652 11.5952 8.74722 11.357 8.46861L11.14 8.21496C10.3016 7.23454 9.88241 6.74432 10.0287 6.27387C10.175 5.80341 10.7899 5.66428 12.0198 5.38601L12.3379 5.31402C12.6874 5.23495 12.8622 5.19541 13.0025 5.0889C13.1428 4.98239 13.2328 4.82097 13.4127 4.49812L13.5766 4.20419Z" fill="white"></path>
                           <path d="M24.2883 9.60209C24.605 9.03403 24.7633 8.75 25 8.75C25.2367 8.75 25.395 9.03403 25.7117 9.60209L25.7936 9.74906C25.8836 9.91048 25.9286 9.9912 25.9988 10.0445C26.0689 10.0977 26.1563 10.1175 26.331 10.157L26.4901 10.193C27.105 10.3321 27.4125 10.4017 27.4856 10.6369C27.5588 10.8722 27.3492 11.1173 26.93 11.6075L26.8215 11.7343C26.7024 11.8736 26.6428 11.9433 26.616 12.0294C26.5892 12.1156 26.5982 12.2085 26.6163 12.3944L26.6327 12.5636C26.696 13.2176 26.7277 13.5447 26.5362 13.6901C26.3447 13.8354 26.0568 13.7029 25.4811 13.4378L25.3321 13.3692C25.1685 13.2939 25.0867 13.2562 25 13.2562C24.9133 13.2562 24.8315 13.2939 24.6679 13.3692L24.5189 13.4378C23.9432 13.7029 23.6553 13.8354 23.4638 13.6901C23.2723 13.5447 23.304 13.2176 23.3673 12.5636L23.3837 12.3944C23.4018 12.2085 23.4108 12.1156 23.384 12.0294C23.3572 11.9433 23.2976 11.8736 23.1785 11.7343L23.07 11.6075C22.6508 11.1173 22.4412 10.8722 22.5144 10.6369C22.5875 10.4017 22.895 10.3321 23.5099 10.193L23.669 10.157C23.8437 10.1175 23.9311 10.0977 24.0012 10.0445C24.0714 9.9912 24.1164 9.91048 24.2064 9.74906L24.2883 9.60209Z" fill="white"></path>
                           <path d="M4.28829 9.60209C4.60495 9.03403 4.76328 8.75 5 8.75C5.23672 8.75 5.39505 9.03403 5.71171 9.60209L5.79363 9.74906C5.88362 9.91048 5.92861 9.9912 5.99876 10.0445C6.06892 10.0977 6.15629 10.1175 6.33103 10.157L6.49012 10.193C7.10504 10.3321 7.4125 10.4017 7.48564 10.6369C7.55879 10.8722 7.34919 11.1173 6.92998 11.6075L6.82152 11.7343C6.70239 11.8736 6.64283 11.9433 6.61603 12.0294C6.58924 12.1156 6.59824 12.2085 6.61625 12.3944L6.63265 12.5636C6.69603 13.2176 6.72772 13.5447 6.53621 13.6901C6.34471 13.8354 6.05683 13.7029 5.48108 13.4378L5.33213 13.3692C5.16852 13.2939 5.08671 13.2562 5 13.2562C4.91329 13.2562 4.83148 13.2939 4.66787 13.3692L4.51892 13.4378C3.94317 13.7029 3.65529 13.8354 3.46379 13.6901C3.27228 13.5447 3.30397 13.2176 3.36735 12.5636L3.38375 12.3944C3.40176 12.2085 3.41076 12.1156 3.38397 12.0294C3.35717 11.9433 3.29761 11.8736 3.17848 11.7343L3.07002 11.6075C2.65081 11.1173 2.44121 10.8722 2.51436 10.6369C2.5875 10.4017 2.89496 10.3321 3.50988 10.193L3.66897 10.157C3.84371 10.1175 3.93108 10.0977 4.00124 10.0445C4.07139 9.9912 4.11638 9.91048 4.20637 9.74906L4.28829 9.60209Z" fill="white"></path>
                        </svg>
                     </div>
                  </div>
               </div>
               <p class="mycustom3">GEWINNEN</p>
            </div>
         </div>
      </div>
      <div class="Custom-Svg-Box3">
         <div class="Custom-Svg-Box3-Inner">
            <p>AUSWÄHLEN</p>
            <p>SPIELEN</p>
            <!--                      <p>Win</p> -->
            <p>GEWINNEN</p>
         </div>
      </div>
   </div>
</div>
</div>



<div class="custom-countdown-banner--main">
   <div class="custom-countdown-banner--main-wrap Page-Width" style="">
      <div class="custom-countdown-banner-data">
         <div class="custom-countdown-banner-data-wrap">
            <h1>Next Competition</h1>
            <p>Hurry! Offers end soon.</p>
            <div id="countdown">
               <div>
                  <span id="days">0</span>
                  <p>Days</p>
               </div>
               <div>
                  <span id="hours">0</span>
                  <p>Hours</p>
               </div>
               <div>
                  <span id="minutes">0</span>
                  <p>Minutes</p>
               </div>
               <div>
                  <span id="seconds">0</span>
                  <p>Seconds</p>
               </div>
            </div>
            <div class="custom-product-sale-btn">
               <a href="">Enter Competition</a>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="custom_main_watch_container custom3rd-boxes-top Page-Width" style="margin-top: 20px;">
   <div class="custom_inner_watch_container Page-Width">
      <div class="Custom-Svg-Box">
         <div class="Custom-Svg-Title">
            <div class="Custom-Svg-Title-Inner Custom-Svg-Title1">
               <h1>
                  UNSERE COMMUNITY<br>
                  <span>HAT GEWONNEN</span>
               </h1>
            </div>
         </div>
         <div class="Custom-Svg-Title Custom-Svg-Title1" style="color: #fff;">
            <p>Wir sind stolz darauf, sorgfältig eineUhrenkollektion zusammenzustellen, die Raffinesse und Eleganz verkörpert</p>
         </div>
      </div>
      <div class="custom_all-box-container">
         <div class="custom_winuwatch-main-item">
            <div class="custom_watch_image">
               <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/07/images_NEW-ROLEX-GMT-MASTER.webp')); ?>" alt="Rolex Wimbledon">
            </div>
            <div class="custom_text_content">
               <h3>Phatek Philippe</h3>
               <h4>gewonnen am 20.06.2024</h4>
               <p>Wert €105k</p>
            </div>
         </div>
         <div class="custom_winuwatch-main-item">
            <div class="custom_watch_image">
               <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/07/images_NEW-ROLEX-GMT-MASTER.webp')); ?>" alt="Rolex Wimbledon">
            </div>
            <div class="custom_text_content">
               <h3>Phatek Philippe</h3>
               <h4>gewonnen am 20.06.2024</h4>
               <p>Wert €105k</p>
            </div>
         </div>
         <div class="custom_winuwatch-main-item custom-mythird">
            <div class="custom_watch_image">
               <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/07/images_NEW-ROLEX-GMT-MASTER.webp')); ?>" alt="Rolex Wimbledon">
            </div>
            <div class="custom_text_content">
               <h3>Phatek Philippe</h3>
               <h4>gewonnen am 20.06.2024</h4>
               <p>Wert €105k</p>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="custom_main_random_container custom-my-title-description-design Page-Width">
   <div class="Custom-Svg-Box">
      <div class="Custom-Svg-Title">
         <div class="Custom-Svg-Title-Inner">
            <h1>
               WIR VERWENDEN DAS
               <span>ZUFALLSGENERATOR</span>
               SYSTEM VON <span>TPAL</span>
            </h1>
         </div>
      </div>
      <div class="Custom-Svg-Title">
         <p>Unser Partner Randomdraws nutzt einen Zufallszahlengenerator eines Drittanbieters für einen unparteiischen und sicheren Auswahlprozess der Gewinner</p>
      </div>
   </div>
   <div class="custom_inner_random_container">
      <div class="custom_all_box_random">
         <div class="custom_box-1_text">
            <div class="custom_main_all_box-1">
               <div class="custom_random_image">
                  <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/07/randomdraws-logo.webp')); ?>" alt="randomdraws-logo.webp">
               </div>
               <p>Unser Partner Randomdraws nutzt einen
                  Zufallszahlengenerator eines Drittanbieters
                  für einen unparteiischen und sicheren
                  Auswahlprozess der Gewinner
               </p>
            </div>
         </div>
         <div class="custom_box-2_draw">
            <div class="custom_main_box-2">
               <h2>Draw certificate example</h2>
               <div class="custom_draw-image">
                  <img src="<?php echo esc_url(site_url('/wp-content/uploads/2024/07/randomdraws-certificate.webp')); ?>" alt="randomdraws-certificate.webp">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Swiper -->
<div class="mycustom-swipper-slider Page-Width">
   <div class="custom-top-slider-data">
      <h1 style="font-weight: bold; text-align: center; width: 100%; max-width: 1000px; margin: 0 auto; margin-bottom: 30px;">
         Warum wir bei der Traumhausverlosung mitmachen
      </h1>
      <div class="cusotm-siwwer-slider-dotted" style="position: absolute; width: 93px; right: 20px; top: 26px;">
         <div class="swiper-button-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
         </div>
         <div class="swiper-button-prev">
            <svg style="transform: rotate(180deg);" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
         </div>
      </div>
   </div>
   <div class="swiper mySwiper">
      <div class="swiper-wrapper">
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/fisrt-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 20px; text-align: center; font-size: 22px;">
                  „Die Kombi gefällt mir! Es macht mir Spaß, ein bisschen mein Glück zu testen und eventuell ein Traumhaus zu gewinnen. Gleichzeitig kann ich etwas für den guten Zweck spenden. Vielleicht 					sieht man mich und meine ErAIndA oshAn hald Nif NAr
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/second-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 30px; text-align: center; font-size: 22px;">
                  „So ein Traumhaus an der Ostseeist für meine Familie und mich die ptimale Gelegenheit, dem lauten lltag der Großstadt zu entfliehen. Außerdem ist es ein großer Gewinn an finanzieller 					Freiheit. Ein doppelter Gewinn sozusagen."
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/third-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 30px; text-align: center; font-size: 22px;">
                  „Normalerweise spiele ich kein otto. Aber ein Traumhaus an der stsee zu gewinnen, wäre schon uper. Hier könnte ich mit meinem ann, Kindern und Enkelkindern olle Urlaube verbringen und 						ielleicht sogar dort hinziehen,
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/fisrt-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 30px; text-align: center; font-size: 22px;">
                  „Die Kombi gefällt mir! Es macht mir Spaß, ein bisschen mein Glück zu testen und eventuell ein Traumhaus zu gewinnen. Gleichzeitig kann ich etwas für den guten Zweck spenden. Vielleicht 					sieht man mich und meine ErAIndA oshAn hald Nif NAr
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/second-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 30px; text-align: center; font-size: 22px;">
                  „So ein Traumhaus an der Ostseeist für meine Familie und mich die ptimale Gelegenheit, dem lauten lltag der Großstadt zu entfliehen. Außerdem ist es ein großer Gewinn an finanzieller 					Freiheit. Ein doppelter Gewinn sozusagen."
               </div>
            </div>
         </div>
         <div class="swiper-slide">
            <div class="my-custom-swipper-data">
               <div class="custom-swipper-slider-image">
                  <img src="https://win.boo/wp-content/uploads/2024/08/third-image.jpeg">
               </div>
               <div class="custom-swipper-wrapper-data" style="padding: 30px; text-align: center; font-size: 22px;">
                  „Normalerweise spiele ich kein otto. Aber ein Traumhaus an der stsee zu gewinnen, wäre schon uper. Hier könnte ich mit meinem ann, Kindern und Enkelkindern olle Urlaube verbringen und 						ielleicht sogar dort hinziehen,
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="custom-blog-post-main">
   <div class="custom-blog-post-wrap">
      <?php
         $args = array(
             'post_type' => 'post', 
             'posts_per_page' => 4, 
             'orderby' => 'date',
             'order' => 'DESC',
         );
         $query = new WP_Query($args);
         if ($query->have_posts()) :
             $post_counter = 1; 
             while ($query->have_posts()) : $query->the_post();
                 $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                 $title = get_the_title();
                 $permalink = get_permalink();
                 $unique_class = "custom-{$post_counter}st-box-blog";
                 $excerpt = wp_trim_words(get_the_excerpt(), 10, '...');
                 ?>
      <a href="<?php echo esc_url($permalink); ?>" class="<?php echo esc_attr($unique_class); ?>">
         <div class="custom-blog-image">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>">
         </div>
         <h1><?php echo esc_html($title); ?></h1>
         <p><?php echo esc_html($excerpt); ?></p>
      </a>
      <?php
         $post_counter++; 
         endwhile;
         else :
         echo '<p>No posts found.</p>';
         endif;
         wp_reset_postdata();
         ?>
   </div>
</div>
<?php
   if ( Plugin::instance()->editor->is_edit_mode() || is_singular() ) {
      ?>
<div id="primary" class="content-area">
   <main id="main" class="site-main">
      <?php
         while ( have_posts() ) : the_post();
             the_content();
         endwhile;
         ?>
   </main>
   <!-- #main -->
</div>
<!-- #primary -->
<?php
   }
   
   ?>
<?php get_footer(); ?>
