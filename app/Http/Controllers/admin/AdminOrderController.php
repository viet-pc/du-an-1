<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminOrderController extends Controller
{
    function index()
    {
        $userId = Session::get('LoggedUser');
        $status = DB::table('status')->select()->get();
        $userRole = DB::table('users')
            ->Join('role', 'users.UserRole', '=', 'role.id_role')
            ->Where('users.UserId', $userId)
            ->Select('role.*')
            ->first();

        if ($userRole->RoleName == 'Manager' || $userRole->RoleName == 'SuperAdmin') {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->Select('orders.*', 'status.*')
                ->OrderBy('orders.OrderId', 'desc')
                ->get();
        } else if ($userRole->RoleName == 'Sale') {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->Where('status.StatusName', 'like', '%Đang chờ xử lí%')
                ->Select('orders.*', 'status.*')
                ->OrderBy('orders.OrderId', 'desc')
                ->Get();
        } else if ($userRole->RoleName == 'Warehouse') {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->Where('status.StatusName', 'like', '%Đã xác nhận%')
                ->Select('orders.*', 'status.*')
                ->OrderBy('orders.OrderId', 'desc')
                ->Get();
        } else if ($userRole->RoleName == 'Shipper') {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->Where('status.StatusName', 'like', '%Đang giao hàng%')
                ->Select('orders.*', 'status.*')
                ->OrderBy('orders.OrderId', 'desc')
                ->Get();
        }
        return view('admin/order/order', compact('orders', 'status', 'userRole'));
    }

    function OrderDetail($OrderId) {
        $userId = Session::get('LoggedUser');
        $orderDetail = DB::table('orders')
            ->Join('orderdetail', 'orders.OrderId', '=', 'orderdetail.OrderId')
            ->Join('product', 'orderdetail.ProductId', '=', 'product.ProductId')
            ->Join('variant', 'orderdetail.VariantId', '=', 'variant.VariantId')
            ->Where('orders.OrderId', $OrderId)
            ->Select('orders.*', 'orderdetail.OrderDetailId', 'variant.Color', 'variant.VariantName', 'orderdetail.Quantity', 'product.Price as ProductPrice', 'variant.Price as VariantPrice')
            ->get();
        $status = DB::table('status')->select()->get();
        $historyOrder = DB::table('historyorder')
            ->Where('OrderId', $OrderId)
            ->Select('CreateAt', 'Description')
            ->orderBy('HistoryOrderId', 'desc')
            ->get();
        $userRole = DB::table('users')
            ->Join('role', 'users.UserRole', '=', 'role.id_role')
            ->Where('users.UserId', $userId)
            ->value('role.RoleName');
        return view('admin/order/orderdetail', compact('orderDetail', 'status', 'historyOrder', 'userRole'));
    }

    function UpdateStatus(Request $request, $orderId, $status) {
        $create_time = Carbon::now();
        $userId = Session::get('LoggedUser');

        $result = DB::table('historyorder')
            ->Where('OrderId', $orderId)
            ->Where('UserId', $userId)
            ->Where('StatusId', $status)
            ->Value('HistoryOrderId');

        if (!$result) {
            $UpdateOrder = DB::table('orders')
                ->where('OrderId', $orderId)
                ->update(['StatusId' => $status]);
            $insertOder = DB::table('historyorder')->insert([
                'CreateAt' => $create_time,
                'StatusId' => $status,
                'OrderId' => $orderId,
                'UserId' => $userId,
                'Description' => $this->InsertDescriptionOfHistoryOrder($status, $userId),
            ]);

            return $UpdateOrder && $insertOder;
        }
    }

    function InsertDescriptionOfHistoryOrder($statusId, $userId) {
        $user = DB::table('users')->select('Fullname')->where('UserId', $userId)->first();
        if ($statusId == 2){
            return 'Đơn hàng đã được xác nhận bởi '.$user->Fullname;
        } else if ($statusId == 3) {
            return 'Đơn hàng đang được giao!';
        } else if ($statusId == 4) {
            return 'Đơn hàng đã được giao thành công đến khách hàng!';
        } else {
            return 'Đơn hàng đã hủy bởi '.$user->Fullname;
        }
    }

    function ShowByStatusOrder(Request $request, $status)
    {
        if ($status == 0) {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->select('orders.*', 'status.*')
                ->orderBy('orders.OrderId', 'desc')
                ->get();
        } else {
            $orders = DB::table('orders')
                ->Join('status', 'orders.StatusId', '=', 'status.StatusId')
                ->where('orders.StatusId', $status)
                ->select('orders.*', 'status.*')
                ->orderBy('orders.OrderId', 'desc')
                ->get();
        }
        return view('admin/order/order_render', compact('orders'));
    }
}
