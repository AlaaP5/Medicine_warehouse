<?php

namespace App\Http\Controllers;

use App\Models\Drugs;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Node\Query\OrExpr;

class OrderContorller extends Controller
{
    //add a new order
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drug' => 'required',
            'drug.*.0' => 'required',
            'drug.*.1' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ]);
        }

        $total = 0;
        $drugs = [];
        $drug = json_decode($request->drug, true);
        foreach ($drug as $item) {
            $drugs[] = [
                'drug_id' => $item[0],
                'quantity_require' => $item[1]
            ];
            $price = Drugs::find($item[0])->price;
            $total += ($item[1] * $price);
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_status' => false,
            'case_id' => 1,
            'total' => $total
        ]);

        $order->drugs()->sync($drugs);

        return response()->json(['data' => $order->load('drugs'), 'message' => 'order add successfully']);
    }

    //display my all order
    public function myOrders()
    {
        $orders = Order::with('cases')->where('user_id', Auth::id())->get();
        $data = [];
        foreach ($orders as $order) {
            if (!$order->payment_status || $order->case_id != 3)
                $data[] = $order;
        }
        return response()->json($data);
    }

    //order content
    public function show($id)
    {
        $order = Order::find($id);
        return $order->load('drugs');
    }

    //display all order
    public function all()
    {
        $orders = Order::with(['cases', 'user'])->get();
        return response()->json($orders);
    }

    //display received orders between to time
    public function history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ]);
        }

        $orders = Order::with('cases')->where('user_id', Auth::id())
            ->where('case_id', 3)
            ->where('payment_status', 1)
            ->get();

        $from = date($request->from);
        $to = date($request->to);

        $data = [];
        foreach ($orders as $order) {
            if ($order->created_at >= min($from, $to) && $order->created_at <= max($from, $to))
                $data[] = $order;
        }

        return response()->json($data);
    }


    //edit order status'
    public function editStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ]);
        }

        $order = Order::with('drugs')->find($request->id);
        foreach ($order->drugs as $item) {
            $w = Drugs::find(($item->id));
            if (($item->pivot->quantity_require) <= ($w->quantity_available)) {
                $w->quantity_available = ($w->quantity_available) - ($item->pivot->quantity_require);
                $w->save();
            }
        }
        $order->case_id = max($request->status, $order->case_id);
        $order->save();
        return response()->json(["message" => 'Order edit statu successfully']);
    }

    //edit order payment status
    public function paymentStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'data' => $validator->errors()
            ]);
        }
        $order = Order::find($request->id);

        $order->payment_status = 1;
        $order->save();
        return response()->json(["masseg" => 'The order received and paid successfully']);
    }
}
