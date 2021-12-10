@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="section-block" id="inputmask">
                <h3 class="section-title">Thêm danh mục mới</h3>
                <p>
                    Thêm đầy đủ các thông tin vào các ô bên dưới để thêm danh mục mới
                </p>
            </div>
            <div class="card">
                @if(session()->has('add-success'))
                    <div style="display: flex" class="card-body col-12">
                        <div class="alert alert-success col3">
                            <strong>Bạn đã thêm thành công " {{session()->pull('add-success')}} " vào danh sách danh mục. </strong>
                        </div>
                    </div>
                @endif
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-4">
                            <label>Tên Danh mục:</label>
                            <input name="CategoryName" type="text" class="form-control date-inputmask" id="date-mask" placeholder="" value="{{old('CategoryName')}}" required/>
                            <input hidden type="text" id="slug_here" name="CategorySlug" value="">
                            <span class="text-danger">@error('CategoryName') {{$message}}@enderror</span>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-8">
                            <label for="formFile" class="form-label">Chọn Ảnh danh mục(1 ảnh)</label>
                            <input name="CategoryImage" class="form-control" type="file" id="upload" onchange="ImagesFileAsURL()">
                            <span class="text-danger">@error('CategoryImage') {{$message}}@enderror</span>
                        </div>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-2">
                            <div style="width:100%" id="displayImg">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex"class="card-body col-12">
                        <label class='col-2' for="">Hoạt Động</label>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="CatActive" id="flexRadioDefault1" value="0" @if(old('CatActive')==0) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Ẩn
                            </label>
                        </div>
                        <div class="form-check col-1">
                            <input class="form-check-input" type="radio" name="CatActive" id="flexRadioDefault1" value="1" @if(old('CatActive')==1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Hiện
                            </label>
                        </div>
                        <span class="text-danger">@error('CatActive') {{$message}}@enderror</span>
                    </div>
                    <div style="display: flex" class="card-body col-12">
                        <div class="form-group col-3">
                            <button type="submit" class="btn btn-outline-primary">Thêm mới danh mục </button>
                        </div>
                    </div>
                </form>
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
