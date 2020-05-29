<?php

namespace App\Http\Controllers\Api;

use App\Entities\Order;
use App\Entities\Product;
use App\Exceptions\MaxRetriesExceededException;
use App\Exceptions\OutOfStockException;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitaraController extends Controller
{
    public function product()
    {
        $products = Product::paginate();
        return new ProductCollection($products);
    }

    public function order()
    {
        $orders = Order::paginate();
        return new OrderCollection($orders);
    }
    
    /**
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function pessimisticOrder(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->findOrFail($id);
            if ($product->stock <= 0) {
                throw new OutOfStockException();
            }
            $product->decrement('stock');

            $order = new Order();
            $order->product_id = $product->id;
            $order->price = $product->price;
            $order->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return response()->json(['message' => 'order success'], 200);
    }

    /**
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function optimisticOrder(Request $request, $id)
    {
        $retries = 0;
        do {
            if ($retries >= 5) {
                throw new MaxRetriesExceededException();
            }
            $product = Product::findOrFail($id);
            if ($product->stock <= 0) {
                throw new OutOfStockException();
            }
            $updated = Product::where([
                'id' => $product->id,
                'updated_at' => $product->updated_at
            ])->update(['stock' => $product->stock - 1]);
            $retries += 1;
        } while (!$updated);
        
        $order = new Order();
        $order->product_id = $product->id;
        $order->price = $product->price;
        $order->save();

        return response()->json(['message' => 'order success'], 200);
    }

}
