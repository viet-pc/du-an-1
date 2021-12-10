@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="inputmask">
                <h3 class="section-title">Sửa Danh Mục Sản Phẩm</h3>
                <p>
                    Điền đầy đủ thông tin vào các ô bên dưới để sửa danh mục.
                </p>
            </div>
            <div class="card">
                @if(session()->has('e-success'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-success col3">
                            <strong>Bạn đã cập nhật thành công danh mục có ID: " {{session()->pull('e-success')}} "</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('e-failed'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-danger col3">
                            <strong>Cập nhật thất bại do trùng tên danh mục khác hoặc danh mục hiện tại. {{session()->forget('e-failed')}}</strong>
                        </div>
                    </div>
                @endif
                @foreach($category as $item)
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label>Tên Danh mục:</label>
                            <input name="CategoryName" type="text" class="form-control date-inputmask" id="date-mask" placeholder="{{$item->CategoryName}}"/>
                            <input hidden type="text" id="slug_here" name="CategorySlug" value="">
                            <input hidden type="text" name="CategoryId" value="{{$item->CategoryId}}">
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-8">
                            <label for="formFile" class="form-label">Chọn Ảnh mặc định (1 Ảnh)</label>
                            <input name="Images" class="form-control" type="file" id="upload" onchange="ImagesFileAsURL()">
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <div id="displayImg">
                                <img src="{{asset('./images/product/'.$item->CategoryImage)}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex"class="card-body col-12">
                        <label class='col-2' for="">Hoạt Động</label>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="CatActive" id="flexRadioDefault1" value="0" @if($item->CatActive == 0) checked @endif >
                            <label class="form-check-label" for="flexRadioDefault1">
                                Ẩn
                            </label>
                        </div>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="CatActive" id="flexRadioDefault1" value="1" @if($item->CatActive == 1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Hiện
                            </label>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-3">
                            <button type="submit" class="btn btn-primary">Cập nhật </button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        //Thiết lập Slug
        $('#date-mask').on('keyup', function(){
            // alert('được');
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
            // alert(slug);
            $('#slug_here').val(slug);
        });
        //Load ảnh xem trước
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
