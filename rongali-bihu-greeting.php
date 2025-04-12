<?php
/*
Plugin Name: Rongali Bihu Greeting Card
Plugin URI: https://github.com/your-username/rongali-bihu-greeting-card
Description: Interactive Rongali Bihu greeting card with name customization and social sharing
Version: 1.0.0
Author: Your Name
Author URI: https://yourwebsite.com
License: GPLv2 or later
Text Domain: rongali-bihu-greeting
*/

defined('ABSPATH') or die('Direct access not allowed!');

class RongaliBihuGreeting {
    public function __construct() {
        add_shortcode('rongali_bihu_greeting', [$this, 'shortcode_output']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('init', [$this, 'load_textdomain']);
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'rongali-bihu-greeting',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }

    public function enqueue_assets() {
        if (has_shortcode(get_post()->post_content, 'rongali_bihu_greeting')) {
            // External dependencies
            wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
            wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
            wp_enqueue_style('noto-sans-assamese', 'https://fonts.googleapis.com/css2?family=Noto+Sans+Assamese:wght@400;700&display=swap');
            
            // Plugin CSS
            wp_enqueue_style('rongali-bihu-css', plugins_url('assets/css/style.css', __FILE__));
            
            // Plugin JS
            wp_enqueue_script(
                'rongali-bihu-js', 
                plugins_url('assets/js/script.js', __FILE__), 
                [], 
                filemtime(plugin_dir_path(__FILE__) . 'assets/js/script.js'), 
                true
            );
            
            // Localize script for translations
            wp_localize_script('rongali-bihu-js', 'rongaliBihuVars', [
                'tapText' => __('টেপ কৰক', 'rongali-bihu-greeting'),
                'namePlaceholder' => __('আপোনাৰ নাম লিখক...', 'rongali-bihu-greeting'),
                'buttonText' => __('শুভেচ্ছা প্ৰেৰণ কৰক', 'rongali-bihu-greeting'),
                'greetingText' => __('ৰঙালী বিহু আৰু অসমীয়া নৱবৰ্ষৰ হিয়া ভৰা ওলগ ও শুভেচ্ছা যাঁচিলো', 'rongali-bihu-greeting')
            ]);
        }
    }

    public function shortcode_output() {
        ob_start();
        ?>
        <div class="rongali-bihu-container">
            <div class="gamosa-curtain">
                <div class="tap-text animate__animated animate__pulse animate__infinite"><?php esc_html_e('টেপ কৰক', 'rongali-bihu-greeting'); ?></div>
                <div class="tap-icon animate__animated animate__bounce animate__infinite">👆</div>
            </div>
            
            <div class="content">
                <div class="greeting-container">
                    <div class="greeting-message animate__animated animate__fadeIn"><?php esc_html_e('ৰঙালী বিহু আৰু অসমীয়া নৱবৰ্ষৰ হিয়া ভৰা ওলগ ও শুভেচ্ছা যাঁচিলো', 'rongali-bihu-greeting'); ?></div>
                    <div class="sender-name animate__animated animate__fadeIn animate__delay-1s" id="senderName"></div>
                </div>
                
                <div class="name-form animate__animated animate__fadeIn animate__delay-1s">
                    <input type="text" id="nameInput" placeholder="<?php esc_attr_e('আপোনাৰ নাম লিখক...', 'rongali-bihu-greeting'); ?>">
                    <button id="sendGreeting"><?php esc_html_e('শুভেচ্ছা প্ৰেৰণ কৰক', 'rongali-bihu-greeting'); ?></button>
                </div>
                
                <div class="social-share animate__animated animate__fadeIn animate__delay-2s">
                    <a href="#" class="share-btn whatsapp" id="whatsappShare"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="share-btn facebook" id="facebookShare"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <div class="floating-elements" id="floatingElements"></div>
            
            <audio id="bgMusic" loop>
                <source src="<?php echo esc_url(plugins_url('assets/audio/bihu-music.mp3', __FILE__)); ?>" type="audio/mpeg">
            </audio>
            
            <div class="audio-control animate__animated animate__pulse animate__infinite animate__slower" id="audioControl">🔊</div>
        </div>
        <?php
        return ob_get_clean();
    }
}

new RongaliBihuGreeting();
