@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between " style="border-bottom: 1px solid #e6e6f2">
                        <h3 class="card-header ">Thống kê phần trăm tỉ lệ hàng hóa trên loại</h3>
                        <buttom class="btn btn-outline-info product-bottom-table">Xem table</buttom>
                    </div>
                    <div id="product"></div>
                    <div class="table_product">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        id="table"
                                        class="table table-striped table-bordered first"
                                    >
                                        <thead style="background-color: var(--cyan)">
                                        <tr>
                                            <th>#</th>
                                            <th>Danh mục</th>
                                            <th>Số lượng</th>
                                            <th>Giá cao nhất</th>
                                            <th>Giá trung bình</th>
                                            <th>Giá thấp nhất</th>
                                        </tr>
                                        </thead>
                                        <tbody>@foreach ($product as  $item)
                                            <tr>
                                                <td>{{$item->CategoryId}}</td>
                                                <td>{{$item->CategoryName}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->maxPrice}}</td>
                                                <td>{{$item->avgPrice}}</td>
                                                <td>{{$item->minPrice}}</td>

                                            </tr>
                                        @endforeach </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between " style="border-bottom: 1px solid #e6e6f2">
                        <h3 class="card-header ">Thống kê doanh thu</h3>
                        <div class="d-flex align-items-center ">
                            <input type="text" name="datetimes"/>
                            <div>
                                <label class="select" for="slct"><select id="type-chart" required="required">
                                        <option value="day">Ngày</option>
                                        <option value="week">Tuần</option>
                                        <option value="month">Tháng</option>
                                    </select>
                                    <svg>
                                        <use xlink:href="#select-arrow-down"></use>
                                    </svg>
                                </label><!-- SVG Sprites-->
                                <svg class="sprites">
                                    <symbol id="select-arrow-down" viewbox="0 0 10 6">
                                        <polyline points="1 1 5 5 9 1"></polyline>
                                    </symbol>
                                </svg>
                            </div>
                            {{--                            <select name="" id="type-chart" class="btn btn-outline-info ">--}}
                            {{--                                <option value="day">Ngày</option>--}}
                            {{--                                <option value="week">Tuần</option>--}}
                            {{--                                <option value="month">Tháng</option>--}}
                            {{--                            </select>--}}
                        </div>

                    </div>
                    <div class="card-body">
                    <div id="total-money-chart-div"></div>
                    </div>
                    <div class="table-responsive total-money-table">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between " style="border-bottom: 1px solid #e6e6f2">
                        <h3 class="card-header">Thống kê tồn kho và đã bán</h3>
                        <buttom class="btn btn-outline-info inventory-bottom-table">Xem table</buttom>
                    </div>
                    <div class="card-body">
                        <canvas id="ct-chart-inventory"></canvas>
                        <div class="table_product_variant">
                            <div class="table-responsive">
                                <table
                                    id="table-1"
                                    class="table table-striped table-bordered first"
                                >
                                    <thead style="background-color: var(--cyan)">
                                    <tr>
                                        <th>#</th>
                                        <th>Sản phẩm</th>
                                        <th>Tồn kho</th>
                                        <th>Đã bán</th>
                                    </tr>
                                    </thead>
                                    <tbody>@foreach ($newSold['stock'] as  $item)
                                        <tr>
                                            <td>{{$item->VariantId}}</td>
                                            <td>{{$item->VariantName}}</td>
                                            <td>{{ $item->Quantity }}</td>
                                            <td>{{$newSold['sold'][ $loop->index]}}</td>

                                        </tr>
                                    @endforeach </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop()
