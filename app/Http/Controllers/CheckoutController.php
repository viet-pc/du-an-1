<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\OrderRequest;

class CheckoutController extends Controller
{
    function index()
    {
        Session::forget('Ship');
        $data = DB::table('shipoption')->value('PricePerKm');
        $shipfee = Session::get('Ship');
        return view('checkout', compact('data', 'shipfee'));
    }

    public function checkoutSubmit(OrderRequest $request)
    {
        //order information
        $full_name = $request->input('Fullname');
        $address = $request->input('Address');
        $phone = $request->input('Phone');
        $email = $request->input('Email');
        $message = $request->input('Message');

        //pay information
        $total = Session::get('Cart')->totalPrice;
        $ship_fee = Session::get('Ship');
        $payment = $request->input('Payment_method');
        if ($payment == '2') {
            $ship_fee = $ship_fee - 100000;
        }
        $to_pay = $total + $ship_fee;

        //time & status of order
        $create_time = Carbon::now();
        $create_by = Session::get('LoggedUser');
        $status = 1; // 1 = Processing order, before it change to 2 for delivering
        $ship_option = Session::get('city_check');//return 1 || 2; value = 1 mean inside hcm city
        if ($ship_option == 1) {
            $delivery_time = 2;// 2 days since checkout
        } else {
            $delivery_time = 5;// 5 days since checkout
        }

        //insert to table orders
        DB::table('orders')->insert([
            'Fullname' => $full_name,
            'Address' => $address,
            'Phone' => $phone,
            'Email' => $email,
            'Note' => $message,
            'ShipFee' => $ship_fee,
            'CreateAt' => $create_time,
            'Subtotal' => $total,
            'ToPay' => $to_pay,
            'ShipDate' => $create_time->addDays($delivery_time)->toDateString(),
            'PaymentId' => $payment,
            'UserId' => $create_by,
            'StatusId' => $status,
            'ShipOptionId' => $ship_option
        ]);

        $Lasted_order_id = DB::table('orders')->latest('OrderId')->value('OrderId');

        //insert to table historyOrder
        DB::table('historyorder')->insert([
            'CreateAt' => $create_time,
            'StatusId' => $status,
            'OrderId' => $Lasted_order_id,
            'UserId' => $create_by,
            'Description' => 'Đã nhận đơn hàng mới #'.$Lasted_order_id.' từ '.$full_name
        ]);

        //product & variant insert into order detail
        $cart = Session::get('Cart')->products;
        foreach ($cart as $item) {
            //insert to orderdetail
            DB::table('orderdetail')->insert([
                'Quantity' => $item['quantity'],
                'ProductId' => $item['productInfo']->ProductId,
                'OrderId' => $Lasted_order_id,
                'VariantId' => $item['productInfo']->VariantId
            ]);
            // reduce quantity of variant
            DB::table('variant')
                ->where('ProductId', '=', $item['productInfo']->ProductId)
                ->where('VariantId','=', $item['productInfo']->VariantId)
                ->update([
                    'quantity' => $item['productInfo']->Quantity - $item['quantity']
                ]);
        }
        //delete session cart
        Session::forget('Cart');

        return redirect('/order-success');
    }

    public function ordersuccessful(){
        return view('cart/order_success');
    }
}
