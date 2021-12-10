@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
            <div class="card">
                <div class="card-body">
                    <h4>Thêm quyền nhân viên</h4>
                    @if (session('add_success'))
                        <div class="alert alert-success">
                            {{ session('add_success') }}
                        </div>
                    @endif
                    <form action="{{asset('/admin/update-config-permission')}}" method="post">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Nhân viên</label>
                                <select id="PermissionUser" class="form-control" name="PermissionUser"
                                        aria-label="Default select example">
                                    <option value="" selected disabled hidden>Chọn nhân viên</option>
                                    <optgroup label="Quản lý">
                                        @foreach($admins as $admin)
                                            @if($admin->RoleName == 'Manager' || $admin->RoleName == 'SuperAdmin')
                                                <option value="{{$admin->UserId}}">
                                                    {{$admin->UserId}} | {{$admin->RoleName}} | {{$admin->Email}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Nhân viên">
                                        @foreach($admins as $admin)
                                            @if($admin->RoleName != 'Manager' && $admin->RoleName != 'SuperAdmin')
                                                <option value="{{$admin->UserId}}">
                                                    {{$admin->UserId}} | {{$admin->RoleName}} | {{$admin->Email}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Chọn quyền</label>
                                <select id="PermissionAction" class="form-control" name="PermissionAction"
                                        aria-label="Default select example">
                                    <option value="" selected disabled hidden>Chọn nhân viên trước</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary">Thêm quyền</button>
                    </form>

                    <hr>

                    <h4>Thiết lập giấy phép</h4>
                    @if (session('licenced'))
                        <div class="alert alert-success">
                            {{ session('licenced') }}
                        </div>
                    @endif
                    <form action="{{asset('/admin/update-config-licenced')}}" method="post">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Nhân viên</label>
                                <select id="LicencedUser" class="form-control" name="LicencedUser"
                                        aria-label="Default select example">
                                    <option value="" selected disabled hidden>Chọn nhân viên</option>
                                    <optgroup label="Quản lý">
                                        @foreach($admins as $admin)
                                            @if($admin->RoleName == 'Manager' || $admin->RoleName == 'SuperAdmin')
                                                <option value="{{$admin->UserId}}">
                                                    {{$admin->UserId}} | {{$admin->RoleName}} | {{$admin->Email}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Nhân viên">
                                        @foreach($admins as $admin)
                                            @if($admin->RoleName != 'Manager' && $admin->RoleName != 'SuperAdmin')
                                                <option value="{{$admin->UserId}}">
                                                    {{$admin->UserId}} | {{$admin->RoleName}} | {{$admin->Email}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Quyền thao tác</label>
                                <select id="LicencedUserPermission" class="form-control" name="LicencedUserPermission"
                                        aria-label="Default select example">
                                    <option value="" selected disabled hidden>Chọn nhân viên trước</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Trạng thái</label>
                                <select id="LicencedStatus" class="form-control" name="LicencedStatus"
                                        aria-label="Default select example">
                                    <option value="" disabled selected>Chọn quyền thao tác</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Cập nhật</button>
                        <div class="test"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //get not exists permission of user selected
            $('#PermissionUser').on('change', function () {
                let permission = $("#PermissionAction");
                let userID = $(this).val();
                permission.empty();
                $.ajax({
                    type: 'GET',
                    url: '/admin/get-user-not-exists-permissions/' + userID,
                })
                    .done(function (data) {
                        permission.append($('<option>').text('Chọn quyền user chưa có').attr('disabled', '').attr('selected', ''));
                        for (let i = 0; i < data.length; i++) {
                            let id_per = data[i]['id_per'];
                            let name_per = data[i]['name_per'];
                            permission.append($('<option>').val(id_per).text(name_per));
                        }
                    })
                    .error(function () {
                        alert("Lỗi");
                    });
            });

            //select user for check user's permission
            $('#LicencedUser').on('change', function () {
                let permission = $("#LicencedUserPermission");
                let userID = $(this).val();
                permission.empty();
                $.ajax({
                    type: 'GET',
                    url: '/admin/get-user-permissions/' + userID,
                })
                    .done(function (data) {
                        permission.append($('<option>').text('Chọn quyền nv').attr('disabled', '').attr('selected', ''));

                        for (let i = 0; i < data.length; i++) {
                            let id_per = data[i]['id_per'];
                            let name_per = data[i]['name_per'];
                            permission.append($('<option>').val(id_per).text(name_per));
                        }
                    })
                    .fail(function () {
                        alert("Lỗi");
                    });
            });

            //select permission for change licenced
            $('#LicencedUserPermission').change(function () {
                let selected = $(this).children('option:selected').val();
                let userID = $('#LicencedUser').children('optgroup').children('option:selected').val();
                console.log(userID);
                $.ajax({
                    type: 'GET',
                    url: '/admin/get-permission-licenced/' + selected + '/' + userID,
                })
                    .done(function (data) {
                        let status = $('#LicencedStatus');
                        status.empty();
                        for (let i = 0; i < 2; i++) {
                            if (i === 0) {
                                status.append($('<option>').val(i).text('Tạm dừng'));
                            } else {
                                status.append($('<option>').val(i).text('Kích hoạt'));
                            }
                        }
                        status.val(data).attr('selected', 'selected');
                    })
                    .fail(function () {
                        alert("Lỗi");
                    });
            })
        });
    </script>
@stop()
