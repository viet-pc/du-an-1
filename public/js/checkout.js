$(document).ready(function () {

    //payment
    $('input[type=radio][name=payment_method]').on('change', function () {
        switch ($(this).val()) {
            case '2':
                $('#before').show("payment-box");
                $('#after').hide("payment-box");
                break;
            case '1':
                $('#after').show("payment-box");
                $('#before').hide("payment-box");
                let total1 = $('#total-before-shipfee').html();
                let ship = $('#totalship').val();
                console.log(total1);
                $('#total-order').html();
                break;
        }
    });

    //---------------validate-----------------
    //full name
    $('#Fullname').bind('change blur', function () {
            let node = $(this);
            let name_regex = /[^a-zA-Z_(0-9)]*$/g;
            node.val(node.val().replace(name_regex, ''));
        }
    );

    //sdt
    $('#Phone').bind('keyup blur', function () {
        let vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        let mobile = $(this).val();
        if (vnf_regex.test(mobile) == false) {
            $('#Phone-validation').html('SĐT chưa đúng định dạng! Ví dụ:0911012345');
        } else {
            $('#Phone-validation').html('');
        }
    });

    //email
    const validateEmail = (email) => {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    };
    const validate = () => {
        const $result = $('#Email-validation');
        const email = $('#Email').val();
        $result.text('');

        if (validateEmail(email)) {
            // $result.text(email + ' là E-mail hợp lệ');
            // $result.removeClass('text-danger');
            // $result.addClass('text-success');
        } else {
            $result.text(email + ' không phải E-mail hợp lệ');
            $result.removeClass('text-success');
            $result.addClass('text-danger');
        }
        return false;
    }
    $('#Email').on('keyup', validate);


// ---------------------DistanceMatrix----------------------------
    let geocoder = new GoongGeocoder({
        accessToken: '6Em1syIO2rI54vIEhIqaXDR69cXg7QW4jaPc2BS1'
    });
// Add geocoder to input
    geocoder.addTo('#geocoder');
    $('.mapboxgl-ctrl-geocoder--input').on('change', function () {
        geocoder.on('result', function (e) {
            $('#kilo').html("<b>Đang tính toán...</b>");

            let json = JSON.stringify(e.result, null, 2);
            let obj = JSON.parse(json);
            let city_check = obj['result']['formatted_address'];
            if (city_check === 'Hồ Chí Minh') {
                city_check = 'Nội thành TPHCM';
                let inside_city = 1
                $.ajax({
                    type: 'GET',
                    url: '/get_shipfee/' + inside_city,
                })
                    .done(function (data) {
                        // $('#thecity').val(inside_city);
                        $('#shipfee-km').html(data);
                        $('#city_check').html(city_check);
                        let latt = obj["result"]["geometry"]["location"]["lat"];
                        let long = obj["result"]["geometry"]["location"]["lng"];
                        let lattCompany = $('#latt').val();
                        let longCompany = $('#long').val();
                        let Url = "https://rsapi.goong.io/DistanceMatrix?origins=" + lattCompany + "," + longCompany + "&destinations=" + latt + "," + long + "&vehicle=car&api_key=6Em1syIO2rI54vIEhIqaXDR69cXg7QW4jaPc2BS1"

                        $.ajax({
                            async: true,
                            url: Url,
                            type: 'GET',
                            success: function (result) {
                                let kilometers = result['rows'][0]['elements'][0]['distance']['text'];//giá trị cuối của ajax
                                let kilo_result = $('#kilo');
                                kilo_result.html(kilometers + " so với vị trí của chúng tôi");
                                $('#shipping-km').html(kilometers);
                                $('#check_location').val('checked');
                                $('#resultkilo').empty();//delete validate
                                kilometers = kilometers.slice(0, -2);
                                let shipfee = $('#shipfee-km').html();
                                shipfee = shipfee * kilometers;
                                $('#totalship').val(shipfee);
                                let formatter = new Intl.NumberFormat().format(shipfee);
                                $('#totalship-fee').html(formatter);
                                //session value
                                $.ajax({
                                    type: 'POST',
                                    url: '/set_session',
                                    data: $("#checkout-form").serialize()
                                })
                                    .done(function () {
                                        let subtotal = $('#total-before-shipfee').val();//giá trước khi
                                        let topay = Number(subtotal) + shipfee
                                        topay = new Intl.NumberFormat().format(topay);
                                        $('#total-order').html(topay)
                                    })
                                    .fail(function () {
                                        alert("Lỗi");
                                    });
                                // to prevent refreshing the whole page page
                                return false;
                            },
                            error: function (error) {
                                console.log(' error ${error}');
                            }
                        });
                    })
                    .fail(function () {
                        alert("Lỗi");
                    });
            } else {
                city_check = 'Ngoài khu vực TPHCM';
                let outside_city = 2;
                $.ajax({
                    type: 'GET',
                    url: '/get_shipfee/' + outside_city,
                })
                    .done(function (data) {
                        // $('#thecity').val(outside_city);
                        $('#shipfee-km').html(data);
                        $('#city_check').html(city_check);
                        let latt = obj["result"]["geometry"]["location"]["lat"];
                        let long = obj["result"]["geometry"]["location"]["lng"];
                        let lattCompany = $('#latt').val();
                        let longCompany = $('#long').val();
                        let Url = "https://rsapi.goong.io/DistanceMatrix?origins=" + lattCompany + "," + longCompany + "&destinations=" + latt + "," + long + "&vehicle=car&api_key=6Em1syIO2rI54vIEhIqaXDR69cXg7QW4jaPc2BS1"

                        $.ajax({
                            async: true,
                            url: Url,
                            type: 'GET',
                            success: function (result) {
                                let kilometers = result['rows'][0]['elements'][0]['distance']['text'];//giá trị cuối của ajax
                                $('#kilo').html(kilometers + " so với vị trí của chúng tôi");
                                $('#shipping-km').html(kilometers);
                                kilometers = kilometers.slice(0, -2);
                                $('#resultkilo').empty();//delete validate
                                let shipfee = $('#shipfee-km').html();
                                $('#check_location').val('checked');
                                shipfee = shipfee * kilometers;
                                if (shipfee > 500000) {
                                    shipfee = 500000
                                }
                                $('#totalship').val(shipfee);
                                let formatter = new Intl.NumberFormat().format(shipfee);
                                $('#totalship-fee').html(formatter);
                                //session value
                                $.ajax({
                                    type: 'POST',
                                    url: '/set_session',
                                    data: $("#checkout-form").serialize()
                                })
                                    .done(function () {
                                        let subtotal = $('#total-before-shipfee').val();//giá trước khi
                                        let topay = Number(subtotal) + shipfee
                                        topay = new Intl.NumberFormat().format(topay);
                                        $('#total-order').html(topay)
                                    })
                                    .fail(function () {
                                        alert("Lỗi");
                                    });
                                // to prevent refreshing the whole page page
                                return false;
                            },
                            error: function (error) {
                                console.log(' error ${error}');
                            }
                        });
                    })
                    .fail(function () {
                        alert("Lỗi");
                    });
            }
        });
    });

//search map options
    $('.mapboxgl-ctrl-geocoder--input').attr("placeholder", "Nhập địa chỉ của bạn");
    $('.mapboxgl-ctrl-geocoder--input').attr('name', 'Address');
    $('.mapboxgl-ctrl-geocoder--input').attr('id', 'Address');
    $('.mapboxgl-ctrl-geocoder--input').attr('required', '');
})
;
