<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_product_attribute;
use App\Models\Order_product_quantity;
use App\Models\Product_attribute_wise_stock;
use App\Models\Product;

class OrderController extends Controller
{
    public function allOrder()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('backend.order.all_order', compact('orders'));
    }

    public function orderDetails(string $id)
    {
        $orders = Order::with('product')->findOrFail($id);
        // dd($orders);
        return view('backend.order.order_details', compact('orders'));
    }

    public function orderConfirm(string $id)
    {
        $datas = Order_product_attribute::where('order_id', $id)->get();
        foreach ($datas as $data) {
            $product_id = $data->product_id;
            $attributes = explode(',', $data->attributes);

            //dd($attributes);

            $attributeIds = [];

            // Loop through the attributes and add them as integers to the array
            foreach ($attributes as $attribute) {
                $attributeIds[] = (int)$attribute; // Append to the array instead of overwriting
            }

            sort($attributeIds);

            //dd($attributeIds);

            // Retrieve the ordered quantity
            $quantity = Order_product_quantity::where('product_id', $product_id)
                ->where('order_id', $id)
                ->first();

            // dd($quantity);

            // Retrieve the current stock for the product attributes
            $currect_stock = Product_attribute_wise_stock::where('product_id', $product_id)
                ->whereIn('attribute_id', $attributeIds) // Pass the array here
                ->get();

            // dd($currect_stock);

            $check = count($currect_stock);
            // dd($check);

            if ($check > 0) {
                foreach ($currect_stock as $stock) {
                    $check_attribute = explode(',', $stock->attribute_id);
                    $ordered_quantity = $quantity ? $quantity->quantity : 0; // Adjust 'quantity' to your actual column name
                    $current_stock_value = $stock ? $stock->stock : 0; // Adjust 'stock' to your actual column name
                    sort($check_attribute);

                    // dd($current_stock_value);

                    if ($check_attribute == $attributeIds) {
                        // Update stock for attribute-wise stock
                        $update_stock = $current_stock_value - $ordered_quantity;
                        $stock->update(['stock' => $update_stock]);
                    }
                }
            } else {
                $product = Product::findOrFail($product_id);
                // dd($product);
                if ($product->quantity > 0) {
                    $stock = $product->quantity - $quantity->quantity;
                    $product->update(['quantity' => $stock]);
                }
            }
        }
        $order = Order::findOrFail($id);

        $order->update(['status' => 'confirmed']);

        $notification = array(
            'message' => 'Order Confirmed',
            'alert-type' => 'success',
        );

        return back()->with($notification);
    }
}
