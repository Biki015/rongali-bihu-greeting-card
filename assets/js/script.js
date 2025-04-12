(function($) {
    $(document).ready(function() {
        // Get localized strings
        const strings = rongaliBihuVars || {};
        
        // Elements
        const $container = $('.rongali-bihu-container');
        const $curtain = $('.gamosa-curtain', $container);
        const $content = $('.content', $container);
        const $senderName = $('#senderName', $container);
        const $nameInput = $('#nameInput', $container);
        const $sendGreeting = $('#sendGreeting', $container);
        const $whatsappShare = $('#whatsappShare', $container);
        const $facebookShare = $('#facebookShare', $container);
        const $floatingElements = $('#floatingElements', $container);
        const $audio = $('#bgMusic', $container)[0];
        const $audioControl = $('#audioControl', $container);
        
        let userInteracted = false;
        
        // Initialize
        createFloatingElements();
        
        // Event handlers
        $curtain.on('click', openCurtain);
        $sendGreeting.on('click', updateSenderName);
        $nameInput.on('keypress', function(e) {
            if (e.key === 'Enter') updateSenderName();
        });
        $audioControl.on('click', toggleAudio);
        
        // Functions
        function createFloatingElements() {
            const emojis = ['🌸', '🌺', '🍃', '✨', '🥁', '🎶'];
            
            for (let i = 0; i < 20; i++) {
                const element = $('<div class="floating"></div>');
                element.text(emojis[Math.floor(Math.random() * emojis.length)]);
                element.css({
                    left: Math.random() * 100 + 'vw',
                    top: Math.random() * 100 + 'vh',
                    fontSize: (Math.random() * 25 + 20) + 'px',
                    animationDuration: (Math.random() * 20 + 10) + 's',
                    animationDelay: (Math.random() * 5) + 's'
                });
                $floatingElements.append(element);
            }
        }
        
        function openCurtain() {
            userInteracted = true;
            $curtain.css('transform', 'translateY(-100%)');
            setTimeout(() => {
                $content.css('opacity', '1');
            }, 1000);
            
            playAudio();
            createConfetti();
        }
        
        function playAudio() {
            if (!userInteracted) return;
            
            $audio.volume = 0.6;
            const playPromise = $audio.play();
            
            if (playPromise !== undefined) {
                playPromise.then(_ => {
                    $audioControl.text('🔊');
                }).catch(error => {
                    $audioControl.text('🔇');
                    console.error("Audio playback failed:", error);
                });
            }
        }
        
        function toggleAudio() {
            userInteracted = true;
            if ($audio.paused) {
                playAudio();
                $audioControl.addClass('animate__rubberBand');
                setTimeout(() => {
                    $audioControl.removeClass('animate__rubberBand');
                }, 1000);
            } else {
                $audio.pause();
                $audioControl.text('🔇');
            }
        }
        
        function updateSenderName() {
            const name = $nameInput.val().trim();
            if (name) {
                $senderName.text(`${name}${strings.nameSuffix || 'ৰ পৰা'}`);
                $senderName.addClass('animate__rubberBand');
                
                setTimeout(() => {
                    $senderName.removeClass('animate__rubberBand');
                }, 1000);
                
                createConfetti();
                updateShareLinks(name);
            } else {
                $nameInput.addClass('animate__shakeX');
                setTimeout(() => {
                    $nameInput.removeClass('animate__shakeX');
                }, 1000);
            }
        }
        
        function updateShareLinks(name) {
            const greetingText = `${strings.greetingText || 'ৰঙালী বিহু আৰু অসমীয়া নৱবৰ্ষৰ হিয়া ভৰা ওলগ ও শুভেচ্ছা যাঁচিলো'} – ${name}${strings.nameSuffix || 'ৰ পৰা'}`;
            const pageUrl = encodeURIComponent(window.location.href);
            
            $whatsappShare.attr('href', `https://wa.me/?text=${encodeURIComponent(greetingText + '\n\n' + pageUrl)}`);
            $facebookShare.attr('href', `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}&quote=${encodeURIComponent(greetingText)}`);
            
            $whatsappShare.add($facebookShare).addClass('animate__bounce');
            setTimeout(() => {
                $whatsappShare.add($facebookShare).removeClass('animate__bounce');
            }, 1000);
        }
        
        function createConfetti() {
            // Confetti creation logic
        }
    });
})(jQuery);
