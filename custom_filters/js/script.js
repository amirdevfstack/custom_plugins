jQuery(document).ready(function($) {
    function fetchProducts(paged = 1, sortby = 'popularity') {
        var data = {
            action: 'cpf_filter_products',
            security: cpf_ajax.nonce,
            paged: paged,
            sortby: sortby,
            range: $('#range').val(),
            type: $('#type').val(),
            industry: $('#industry').val(),
            pressure: $('#pressure').val(),
            power: $('#power').val(),
        };

        $.post(cpf_ajax.ajax_url, data, function(response) {
            $('#cpf-results').html(response);

           
            renderPagination(paged);
        });
    }

    function renderPagination(currentPage) {
        var totalPages = $('.cpf-page-link').last().data('page');  
        var visiblePages = 3;  

        $('.cpf-page-link').hide();  

      
        var startPage = Math.max(1, currentPage - 1);
        var endPage = Math.min(totalPages, currentPage + 1);

       
        if (currentPage === 1) {
            endPage = Math.min(totalPages, 3);
        } else if (currentPage === totalPages) {
            startPage = Math.max(1, totalPages - 2);
        }

     
        for (var i = startPage; i <= endPage; i++) {
            $('.cpf-page-link[data-page="' + i + '"]').show();
        }

      
        if (currentPage > 1) {
            $('.cpf-page-link[data-page="' + (currentPage - 1) + '"]').show().text('Prev');
        }

        if (currentPage < totalPages) {
            $('.cpf-page-link[data-page="' + (currentPage + 1) + '"]').show().text('Next');
        }
    }

    
    $(document).on('click', '.cpf-page-link', function(e) {
        e.preventDefault();
        var paged = $(this).data('page');
        var sortby = $('#sortby').val();
        fetchProducts(paged, sortby);
    });

    
    $('#sortby').on('change', function() {
        fetchProducts(1, $(this).val());
    });

    $('#range, #type, #industry, #pressure, #power').on('change', function() {
        fetchProducts();  
    });

    
    fetchProducts();




   
    filterNews();

    
    $('#news-filter-form select').change(function() {
        filterNews(); 
    });

    
    $(document).on('click', '.news-pagination a', function(e) {
        e.preventDefault();
        var paged = $(this).attr('href').split('paged=')[1]; 
        filterNews(paged); 
    });

    function filterNews(paged = 1) {
        var filterData = $('#news-filter-form').serialize(); 
        filterData += '&paged=' + paged; 

        $.ajax({
            url: cpf_ajax.ajax_url,
            type: 'POST',
            data: filterData + '&action=filter_news', 
            beforeSend: function() {
                $('#news-results').html('<p>Loading...</p>'); 
            },
            success: function(response) {
                $('#news-results').html(response); 
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error); 
            }
        });
    }


   
    


});





