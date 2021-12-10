
$(document).ready(function(){

    function searchProducts(query="") {
        $.ajax({
            url:"search",
            method:'GET',
            data:{keyword:query},
            dataType:"json",
            success: function (data){
                $('.showing-item').html(data.totalRow);
                $('#shop-1 .row').html(data.html);
                $('.paginate').html(data.paginate);
            }
        })
    }
    $(document).on('keypress','#search-all',function (e){
        let query = $(this).val();
        if(e.which === 13) {
            searchProducts(query);
        }

    })
})
