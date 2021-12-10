@extends('layouts.admin')
@section('main')
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: #e8e8e8;
            float: left;
            border:none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            color: black;
            margin-right: 5px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #dedede;
            color: black;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            box-shadow:  1px 1px 8px black;
            background-color: white;
            color:black;
            z-index: 10;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .tabcontent {
            animation: fadeEffect 1s; /* Fading effect takes 1 second */
        }

        /* Go from zero to full opacity */
        @keyframes fadeEffect {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        #displayImg img{
            width:100%;
        }
    </style>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="inputmask">
                <h3 class="section-title">Sửa thông tin sản phẩm</h3>
                <p>
                    Thêm đầy đủ các thông tin sản phẩm vào các ô bên dưới để chỉnh sửa sản phẩm mới
                </p>
            </div>

            <div class="tab">
                <button class="tablinks" id="defaultOpen" onclick="openCity(event,'Addproduct')">Sửa sản phẩm</button>
                <button class="tablinks" onclick="openCity(event,'Addvariant')">Sửa biến thể sản phẩm</button>
            </div>
            <div id="Addproduct" class="tabcontent card">
                @if(session()->has('edit-success'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-success col3">
                            <strong>Bạn đã cập nhật thành công sản phẩm có ID: " {{session()->pull('edit-success')}}".</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('add-success-f'))
                @else
                    @if(session()->has('edit-failed'))
                        <div style="display: flex" class="card-body col-12">
                            <div class="alert alert-danger col3">
                                <strong>Cập nhật thất bại do bị trùng tên sản phẩm khác hoặc sản phẩm hiện tại {{session()->forget('edit-failed')}}.</strong>
                            </div>
                        </div>
                    @endif
                @endif
                @if(session()->has('thua'))
                    <div style="display: flex" class="card-body col-12">
                        @if(session('duoc')!=0)
                        <div class="alert alert-success col2">
                            <strong>{{session()->pull('duoc')}} hình được thêm vào.</strong>
                        </div>
                        @endif
                        <div class="alert alert-danger col2">
                            <strong>***Chú ý: Có {{session()->pull('thua')}} hình chưa được thêm vì quá số lượng tối đa là 8 hình.</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('add-success-v'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-success col3">
                            <strong>Bạn đã cập nhật thành công biến thể có ID: " {{session()->pull('add-success-v')}} "</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('add-success-f'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-danger col3">
                            <strong>Cập nhật thất bại do trùng tên biến thể khác hoặc tên hiện tại của biến thể{{session()->forget('add-success-f')}}.</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('del-success-v'))
                        <div style="display: flex" class="card-body col-12">
                            <div class="alert alert-danger col3">
                                <strong>Bạn đã xóa thành công biến thể có ID: " {{session()->pull('del-success-v')}} "</strong>
                            </div>
                        </div>
                @endif

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach($get_product as $item)
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label>Tên Sản Phẩm:</label>
                            <input name="ProductName" type="text" class="form-control date-inputmask" id="date-mask" placeholder="" value="{{$item->ProductName}}" required/>
                            <input hidden type="text" id="slug_here" name="Slug" value="">
                            <input hidden id = 'proid' name="ProductId" value="{{$item->ProductId}}">
                        </div>
                        <div class="form-group col-4" >
                            <label>Danh Mục sản phẩm </label>
                            <select class="form-control" name="CategoryId" id="" required>
                                <option no value>Chọn</option>
                                @foreach($categoryAll as $cat)
                                    <option value="{{$cat->CategoryId}}" @if($cat->CategoryId==$item->CategoryId) selected @endif>{{$cat->CategoryName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Nhà Phân Phối </label>
                            <select class="form-control" name="SupplierId" id="" required>
                                <option no value>Chọn</option>
                                @foreach($supplier as $sup)
                                    <option value="{{$sup->SupplierId}}" @if($sup->SupplierId==$item->SupplierId) selected @endif>{{$sup->SupplierName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label for="inputText4" class="col-form-label">Giá (VNĐ)</label>
                            <input required name="Price" id="price" type="text" class="form-control" placeholder="Nhập giá sản phẩm" value="{{$item->Price}}"/>
                            <input hidden type="number" id="price_new" name="price_new" value="{{$item->Price}}"/>
                        </div>
                        <div class="form-group col-4">
                            <label for="inputText4" class="col-form-label">Giảm giá <small>(Từ 0-1)</small></label>
                            <input required name="Discount" id="inputText4" type="number" step="0.01" max="1" min="0" class="form-control" placeholder="Nhập giảm giá" value="{{$item->Discount}}"/>
                        </div>
                        <div class="form-group col-4">
                            <label for="inputText4" class="col-form-label">Khối lượng <small>(Kilogram)</small></label>
                            <input required name="Weight" id="inputText4" type="number" step="0.01" min="0" class="form-control" placeholder="Nhập Khối lượng" value="{{$item->Weight}}"/>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-8">
                            <label for="formFile" class="form-label">Chọn Ảnh mặc định (1 Ảnh)</label>
                            <input name="Images" class="form-control" type="file" id="upload" onchange="ImagesFileAsURL()" value="{{$item->Images}}">
                        </div>
                        <div class="form-group col-3">
                            <div id="displayImg">
                                <img style="width:100%" src="{{asset('/images/product/'.$item->Images)}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-12">
                            <label for="inputText4" class="col-form-label">Ảnh hiện có của sản phẩm: (Tối đa số lượng hình là 8)</label>
                        </div>
                    </div>

                    <div style="display: flex" class="card-body col-12" id="load-img-details">
{{--                        @foreach($image as $img)--}}
{{--                            <div class="form-group col-2">--}}
{{--                                <img style="width:100%" src="{{asset('/images/product/'.$img->images)}}" alt="">--}}
{{--                                <a href="/admin/product/delete-img/{{$img->ImageId}}">Xóa Ảnh</a>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-8">
                            <label for="formFileMultiple" class="form-label">Chọn thêm ảnh chi tiết sản phẩm </label>
                            <input name="images_multiple[]" class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-12">
                            <label for="exampleFormControlTextarea1">Mô Tả sản phẩm</label>
                            <textarea required name="Descreption" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$item->Descreption}}</textarea>
                        </div>
                    </div>
                    <div style="display: flex"class="card-body col-12">
                        <label class='col-2' for="">Hoạt Động</label>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="Active" id="flexRadioDefault1" value="0" @if($item->Active==0) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Ẩn
                            </label>
                        </div>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="Active" id="flexRadioDefault1" value="1" @if($item->Active==1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Hiện
                            </label>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-3">
                            <button type="submit" class="btn btn-primary">Cập Nhật </button>
                            <x-permission per="Delete"
                                          href="{{asset('admin/product/delete-product/'.$item->Slug)}}"></x-permission>
                        </div>
                    </div>
                    @endforeach
                </form>
            </div>

            <div id="Addvariant" class="tabcontent card">
                @php $stt=0; @endphp
                @foreach($variant as $var)

                <form action="{{route('edit-variant')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; padding-bottom: 0" class="card-body col-12">
                        <div class="form-group col-4">
                            <h3 style="color:red;">Biến thể {{$stt=$stt+1}} - ID biến thể: {{$var->VariantId}}</h3>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label class="col-form-label">Tên biến thể:</label>
                            <input name="VariantName" type="text" class="form-control date-inputmask" id="date-mask" placeholder="{{$var->VariantName}}"/>
                            <input hidden name="VariantId" value="{{$var->VariantId}}">
                            <input hidden name="Slug" value="{{$item->Slug}}">
                            <input hidden name="ProductId" value="{{$item->ProductId}}">
                        </div>
                        <div class="form-group col-4">
                            <label for="inputText4" class="col-form-label">Giá (tăng bao nhiêu % so với giá sản phẩm)</label>
                            <input required name="Price_variant" id="inputText4" type="number" step="1" max="100" min="0" class="form-control" value="{{$var->Price*100}}" placeholder="Nhập giá biến thể"/>
                        </div>
                        <div class="form-group col-4">
                            <label for="inputText4" class="col-form-label">Số lượng <small>(Cái)</small></label>
                            <input required name="Quantity" id="inputText4" type="number" step="1" min="0" class="form-control" value="{{$var->Quantity}}" placeholder="Nhập số lượng"/>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-8">
                            <label for="formFile" class="form-label">Chọn Ảnh mặc định (1 Ảnh)</label>
                            <input name="Images" class="form-control" type="file" id="upload" onchange="ImagesFileAsURL()" value="">
                        </div>
                        <div class="form-group col-2">
                            <div id="displayImg2">
                                <img style="width:100%" src="{{asset('/images/product/'.$var->Color)}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div style="padding-top:0;display: flex" class="card-body col-12">
                        <div class="form-group col-12">
                            <label for="exampleFormControlTextarea1">Mô tả biến thể</label>
                            <textarea required name="Description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$var->Description}}</textarea>
                        </div>
                    </div>
                    <div style="padding-top:0; padding-bottom:0;display: flex"class="card-body col-12">
                        <label class='col-2' for="">Hoạt Động</label>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="Active" id="flexRadioDefault1" value="0" @if($var->Active ==0) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Ẩn
                            </label>
                        </div>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="Active" id="flexRadioDefault1" value="1" @if($var->Active ==1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Hiện
                            </label>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-1">
                            <button type="submit" class="btn btn-primary">Cập Nhật </button>
                        </div>
                        <div class="form-group col-1">
                            <x-permission per="Delete"
                                          href="{{asset('admin/product/delete-variant/'.$var->VariantId)}}"></x-permission>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        //Hàm Load Ajax
        function load_img() {
            //Lấy Id sản phẩm và token
            let productId = $("input[name='ProductId']").val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url("/load-img")}}",
                method:"POST",
                data:{
                    productId:productId,
                    _token:_token
                },
                success:function(data){
                    $('#load-img-details').html(data);
                }
            });
        }
        //Gọi hàm load ảnh
        $(document).ready(function(){
            load_img();
        });
        //Lấy id Ảnh để xử lí ajax và xóa ảnh
        function getIdimg(){
            let idimg= $('input[name="emotion"]:checked').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url("/delete-img")}}",
                method:"POST",
                data:{
                    idimg:idimg,
                    _token:_token
                },
                success:function(data){
                    load_img();
                }
            });
        }
        //Thiết lập Slug
        $('#date-mask').on('keyup', function(){
            let title = $(this).val();
            //Đổi chữ hoa thành chữ thường
            let slug = title.toLowerCase();
            // Tạo Slug bắt đầu:
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            $('#slug_here').val(slug);
        });

        //Định dạng input giá
        {{--Định dạng 10000000 thành 10,000,000 mất vài tiếng để nghiên cứu ra được 10 dòng code (Khóc)--}}
        $("#price").on('keyup', function(){
            var n = parseInt($(this).val().replace(/\D/g,''),10);
            if(n>=0){
                $('#price').val(n.toLocaleString("de-DE"));
                $('#price_new').val(n);
            }
            if(isNaN(n)){
                $('#price').val('');
            }
        });

        //Xử lí tab
        document.getElementById("defaultOpen").click();
        function openCity(evt, cityName) {
            //Tạo biến
            var i, tabcontent, tablinks;
            // Lấy tất cả thành phần của tabcontent
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            // Nhận tất cả các phần tử với class = "tablinks" và xóa class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Hiển thị tab hiện tại và thêm một lớp class "active" vào nút đã mở tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        // Hàm load ảnh xem trước
        function ImagesFileAsURL() {
            var fileSelected = document.getElementById('upload').files;
            if(fileSelected.length > 0) {
                var fileToLoad = fileSelected[0];
                var fileReader = new FileReader();
                fileReader.onload = function(fileLoaderEvent) {
                    var scrData = fileLoaderEvent.target.result;
                    var newImage = document.createElement("img");
                    newImage.src = scrData;
                    document.getElementById('displayImg').innerHTML = newImage.outerHTML;
                }
                fileReader.readAsDataURL(fileToLoad);
            }
        }
    </script>
@stop()
