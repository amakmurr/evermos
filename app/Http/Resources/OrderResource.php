<?php

namespace App\Http\Resources;

use App\Entities\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var mixed
     */
    public $resource = Order::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = parent::toArray($request);
        $result['product'] = $this->product;
        return $result;
    }
}
