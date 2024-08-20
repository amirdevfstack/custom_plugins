jQuery(document).ready(function($) {
    $('td.label label[for="pa_size"]').hide();
    $('.variant-image').on('click', function() {    
        let colorVariant = $(this).data('value');
        let product_id = $(this).data('product_id');
        $.ajax({
            url: woocommerce_color_variants_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_sizes_for_color_variant',
                color_variant: colorVariant,
                product_id: product_id
            },
            success: function(response) {
                // alert(response);
                // return;
                if (response) {
                    var html = '<table class="size-variants-table">';
                    html += '<thead>';
                    html += '<tr><th>Size</th><th>1-24no</th><th>Over 24no</th><th>Over 100no</th><th>Quantity</th><th>Select Quantity</th></tr>';
                    html += '</thead>';
                    html += '<tbody>';
                    $.each(response, function(index, sizeData) {
                        var price1Html = $('<div/>').html(sizeData.price1.toFixed(2)).text();
                        var price2Html = $('<div/>').html(sizeData.price2.toFixed(2)).text();
                        var price3Html = $('<div/>').html(sizeData.price3.toFixed(2)).text();
            
                        html += '<tr>';
                        html += '<td>' + sizeData.size + '</td>';
                        html += '<td class="price">' + price1Html + '</td>';
                        html += '<td class="price">' + price2Html + '</td>';
                        html += '<td class="price">' + price3Html + '</td>';
                        html += '<td>' + sizeData.quantity + '</td>';
                        html += '<td>' +
                            '<div class="quantity-container">' +
                            '<input type="number" class="quantity-input size-quantity" data-size="' + sizeData.size + '" data-price="' + price1Html + '" data-base-price="' + price1Html + '" data-product-id="' + product_id + '" data-variation-id="' + sizeData.variation_id + '" data-color-variant="' + colorVariant + '" min="1" max="' + sizeData.quantity + '" value="1">' +
                            '<div class="quantity-buttons">' +
                            '<span class="quantity-button" onclick="changeQuantity(event, this, 1)">+</span>' +
                            '<span class="quantity-button quantity-btn-minus" onclick="changeQuantity(event, this, -1)">-</span>' +
                            '</div>' +
                            '</div>' +
                            '</td>';
                        html += '</tr>';
                    });
                    html += '</tbody>';
                    html += '</table>';
                    html += '<button id="add-all-to-cart">Add All to Cart</button>';
                 
                    let element = document.querySelector('.quantity'); 
                    let price = document.querySelector('p.price'); 
                    // If the element exists, set its display property to 'none'
                    if (element) {
                    element.style.display = 'none';
                    }
                                        price.style.display = 'none !important';
                    $('#variant-data-placeholder').html(html);
							//change image atttribute
                if (response.length > 0 && response[0].image_url) {
                        var imageUrl = response[0].image_url;
                        alert(imageUrl);
                        return;
                        // Update main image src and href
                        $('.size-woocommerce_single').attr('src', imageUrl);
                        $('.woocommerce-product-gallery__image a').attr('href', imageUrl); // Update href dynamically

                        // Update zoom image
                        $('.woocommerce-product-gallery__image .cloud-zoom img').attr('src', imageUrl);
                    }
					

                    $('#add-all-to-cart').on('click', function(e) {
                        e.preventDefault();
                        // alert('Adding all to cart');
                        // return;
                        var items = [];
                        $('.size-quantity').each(function() {
                            var quantity = $(this).val();
                            if (quantity > 0) {
                                items.push({
                                    size: $(this).data('size'),
                                    price: $(this).data('price'),
                                    product_id: $(this).data('product-id'),
                                    variation_id: $(this).data('variation-id'),
                                    color_variant: $(this).data('color-variant'),
                                    quantity: quantity
                                });
                            }
                        });
                        
                        if (items.length > 0) {
                            $.ajax({
                                url: woocommerce_color_variants_ajax.ajax_url,
                                type: 'POST',
                                data: {
                                    action: 'add_all_to_cart',
                                    items: items
                                },
                                success: function(response) {
                                    if (response.success) {
//                                         alert('Items added to cart');
                                         Swal.fire({
											  title: 'Done',
											  text: 'Products added to cart',
											  icon: 'success',
											  confirmButtonText: 'OK'
											}).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
// 										 window.location.reload();
                                    } else {
                                        alert('Failed to add items to cart');
                                    }
                                }
                            });
                        }
                    });
                } else {
                    console.log('No data received from server');
                }
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Select all table rows with class 'woocommerce-cart-form__cart-item cart_item'
    const cartItems = document.querySelectorAll('tr.woocommerce-cart-form__cart-item.cart_item');
    
    cartItems.forEach(cartItem => {
        // Select the anchor tag within 'product-thumbnail' class in each cart item
        const productThumbnail = cartItem.querySelector('.product-thumbnail a');
        if (productThumbnail) {
            // Get the original href
            let href = productThumbnail.getAttribute('href');
            // Remove the query parameters
            let newHref = href.split('/?')[0];
            // Set the new href
            productThumbnail.setAttribute('href', newHref);
        }

        // Select the anchor tag within 'product-name' class in each cart item
        const productName = cartItem.querySelector('.product-name a');
        if (productName) {
            // Get the original href
            let href = productName.getAttribute('href');
            // Remove the query parameters
            let newHref = href.split('/?')[0];
            // Set the new href
            productName.setAttribute('href', newHref);
        }
    });
	setInterval(function() {
        const cartItems = document.querySelectorAll('tr.woocommerce-cart-form__cart-item.cart_item');
        cartItems.forEach(cartItem => {
            const productThumbnail = cartItem.querySelector('.product-thumbnail a');
            if (productThumbnail) {
                let href = productThumbnail.getAttribute('href');
                let newHref = href.split('/?')[0];
                productThumbnail.setAttribute('href', newHref);
            }

            const productName = cartItem.querySelector('.product-name a');
            if (productName) {
                let href = productName.getAttribute('href');
                let newHref = href.split('/?')[0];
                productName.setAttribute('href', newHref);
            }
        });
    }, 1000); // 2000 milliseconds = 2 seconds
});

// Function to change quantity
function changeQuantity(event, element, delta) {
    event.preventDefault();
    const input = element.closest('.quantity-container').querySelector('.quantity-input');
    const minValue = parseInt(input.getAttribute('min')) || 1;
    const maxValue = parseInt(input.getAttribute('max')) || Infinity;
    let value = parseInt(input.value) || 1;

    value += delta;
    if (value >= minValue && value <= maxValue) {
        input.value = value;
    }
}