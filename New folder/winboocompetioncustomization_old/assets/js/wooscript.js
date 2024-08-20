jQuery(document).ready(function($) {
    var selectedQuantity = 1;
    var selectedDiscount = 0;

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
        alert('Total Price: ' + totalPrice); 
    });


    
    $('.next-step-btn').on('click', function() {
        var productId = phpVars.productId; 
       
        var entryPrice = parseFloat(phpVars.entryPrice);
        var discountRate = getDiscountRate(selectedQuantity);
        var totalPrice = selectedQuantity * entryPrice * (1 - discountRate / 100);
        alert('Total Price: ' + totalPrice); 

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






});
