jQuery(document).ready(function($) {
    var selectedQuantity = 1;
    var selectedDiscount = 0;
    var totalTickets = phpVars.totalQuantity; // Get the total number of tickets

    function getDiscountRate(quantity) {
        var discountRate = 0;
        if (quantity >= 50) {
            discountRate = parseFloat(phpVars.discountQuantity50);
        } else if (quantity >= 25) {
            discountRate = parseFloat(phpVars.discountQuantity25);
        } else if (quantity >= 20) {
            discountRate = parseFloat(phpVars.discountQuantity20);
        } else if (quantity >= 15) {
            discountRate = parseFloat(phpVars.discountQuantity15);
        }
        return discountRate;
    }

    function updateChanceToWin($element, quantity) {
        var chance = `1/${Math.ceil(totalTickets / quantity)} chance to win`; // Calculate based on total tickets
        $element.find('.chance-to-win').text(chance);
    }

    function updateAllChances() {
        $('.vip-btn').each(function() {
            var quantity = $(this).data('vip');
            updateChanceToWin($(this), quantity);
        });
        $('.quantity-btn').each(function() {
            var quantity = $(this).data('quantity');
            updateChanceToWin($(this), quantity);
        });
    }

    $('.product-thumbnail').on('click', function(e) {
        e.preventDefault(); 
        var newImageUrl = $(this).attr('src');
        var newImageSrcset = $(this).attr('srcset');
        $('.product-main-image').attr({
            'src': newImageUrl,
            'srcset': newImageSrcset
        });
    });

    $('.quantity-btn, .vip-btn').on('click', function() {
        $('.quantity-btn, .vip-btn').removeClass('selected');
        $(this).addClass('selected');

        selectedQuantity = $(this).data('quantity') || $(this).data('vip');
        selectedDiscount = $(this).data('discount') || 0;

        var entryPrice = parseFloat(phpVars.entryPrice);
        var discountRate = getDiscountRate(selectedQuantity);
        var totalPrice = selectedQuantity * entryPrice * (1 - discountRate / 100);

        updateChanceToWin($(this), selectedQuantity);
    });

    $('.next-step-btn').on('click', function() {
        var productId = phpVars.productId; 
        var entryPrice = parseFloat(phpVars.entryPrice);
        var discountRate = getDiscountRate(selectedQuantity);
        var totalPrice = selectedQuantity * entryPrice * (1 - discountRate / 100);

        $.ajax({
            url: phpVars.ajaxUrl,
            method: 'POST',
            data: {
                action: 'add_product_to_cart',
                product_id: productId,
                quantity: selectedQuantity,
                total_price: totalPrice
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = phpVars.checkoutUrl;
                } else {
                    alert('Failed to add product to cart.');
                }
            }
        });
    });

    if (phpVars.drawDate) {
        function parseDate(dateStr) {
            var parts = dateStr.split('-');
            if (parts.length !== 3) {
                console.error('Date format is incorrect');
                return new Date();
            }
            var month = parseInt(parts[0], 10) - 1; 
            var day = parseInt(parts[1], 10);
            var year = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }

        var drawDate = parseDate(phpVars.drawDate).getTime();

        var countdownTimer = setInterval(function() {
            var now = new Date().getTime();
            var distance = drawDate - now;
            if (distance < 0) {
                clearInterval(countdownTimer);
                document.getElementById('countdown-timer').innerHTML = 'The draw has ended';
                return;
            }
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById('countdown-timer').innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
        }, 1000);
    }

    var soldQuantity = phpVars.soldQuantity;
    var soldPercentage = (soldQuantity / totalTickets) * 100;
    $('#tickets-sold-count').text(soldQuantity);
    $('#total-tickets').text(totalTickets);
    $('#sold-percentage').text(soldPercentage.toFixed(0) + '%');
    $('.progress-bar-fill').css('width', soldPercentage.toFixed(0) + '%');

    // Initial update for chance to win based on default selected quantity
    updateAllChances();
    updateChanceToWin($('.quantity-btn.selected, .vip-btn.selected'), selectedQuantity);
	
	
	
	
});
