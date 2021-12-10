@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
            <div class="card">
                <div class="card-body">
                    <h3>Thiết lập thông tin</h3>
                    <div>
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Tên thương hiệu</label>
                                <input type="text" class="form-control date-inputmask" placeholder="Nhập địa chỉ công ty" id="Name" value="{{$data->Name}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Địa chỉ công ty</label>
                                <input type="text" class="form-control date-inputmask" placeholder="Nhập địa chỉ công ty" id="Address" value="{{$data->Address}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Số điện thoại</label>
                                <input type="number" class="form-control date-inputmask" placeholder="Nhập số điện thoại" id="Phone" value="{{$data->Phone}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Email</label>
                                <input type="email" class="form-control date-inputmask" placeholder="Nhập Email công ty" id="Email" value="{{$data->Email}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Facebook</label>
                                <input type="text" class="form-control date-inputmask" placeholder="Nhập liên kết Facebook" id="Facebook" value="{{$data->Facebook}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Instagram</label>
                                <input type="text" class="form-control date-inputmask" placeholder="Nhập liên kết Instagram" id="Instagram" value="{{$data->Instagram}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Zalo</label>
                                <input type="text" class="form-control date-inputmask" placeholder="Nhập liên kết Zalo" id="Zalo" value="{{$data->Zalo}}"/>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Thời gian mở cửa</label>
                                <input type="time" class="form-control date-inputmask" placeholder="Nhập thời gian mở cửa" id="OpenTime" value="{{$data->OpenTime}}"/>
                            </div>                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Thời gian đóng cửa</label>
                                <input type="time" class="form-control date-inputmask" placeholder="Nhập thời gian đóng cửa" id="CloseTime" value="{{$data->CloseTime}}"/>
                            </div>
                            <div class="form-group col-12">
                                <label for="Logo" class="col-sm-2 col-form-label">Logo</label>
                                <div class="dropzone" id="Logo" type="file"></div>
                                <span>Chỉ tải lên ảnh mới khi bạn muốn cập nhật logo</span>
                            </div>
                        </div>
                        <button type="submit" onclick="update()" class="btn btn-outline-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
<script>
    logo = '{{$data->Logo}}';
    function update(){
    $.ajax({
            url: '{{url("api/information/update")}}',
            type: 'POST',
            data: {
                Name: $("#Name").val(),
                Address: $("#Address").val(),
                Phone: $("#Phone").val(),
                Facebook: $("#Facebook").val(),
                Instagram: $("#Instagram").val(),
                Zalo: $("#Zalo").val(),
                OpenTime: $("#OpenTime").val(),
                CloseTime: $("#CloseTime").val(),
                Email: $("#Email").val(),
                Logo: logo,
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
              Notiflix.Notify.Success(res.messages);
              setTimeout(function () { location.reload(true); }, 2000);
            }else{
              Notiflix.Notify.Warning(res.messages);
            }
        });
    }
</script>

<script>

new Dropzone("#Logo", {
    url: "/api/upload/image",
    paramName: 'upload',
    maxFilesize: 2,
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "Kéo file logo của bạn vào đây",
    dictMaxFilesExceeded: "Bạn chỉ có thể tải lên 1 ảnh",
    dictRemoveFile: "Xoá",
    dictCancelUploadConfirmation: "Bạn muốn huỷ tải lên?",
    headers: {
        'x-csrf-token': '{{csrf_token()}}'
    },
    init: function () {
        this.on("success", function (file, responseText) {
        console.log(responseText);
        logo = responseText.fileName;
        console.log(thumbnail);
      });
    }
});
</script>
@stop()