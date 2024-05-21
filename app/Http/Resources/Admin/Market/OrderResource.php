<?php

namespace App\Http\Resources\Admin\Market;

 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'order_final_amount'=>$this->order_final_amount,
            'order_discount_amount'=>$this->order_discount_amount,
            'order_copan_discount_amount'=>$this->order_copan_discount_amount,
            'order_total_products_discount_amount'=>$this->order_total_products_discount_amount,
            'order_common_discount_amount'=>$this->order_common_discount_amount,
            'delivery'=>new DeliveryResource($this->whenLoaded('delivery')),
            'paymentStatusValue'=>$this->paymentStatusValue ,
            'paymentTypeValue'=>$this->paymentTypeValue ,
            'deliveryStatusValue'=>$this->deliveryStatusValue,
            'orderStatusValue'=>$this->orderStatusValue,
            'address'=>$this->whenLoaded('address'),
            'payment'=>new PaymentResource($this->whenLoaded('payment')),
            'user'=>$this->user,
            'orderItems'=>   OrderItemResource::collection($this->whenLoaded('orderItems')) ,
            'commonDiscount'=>new CommonDiscountResource($this->whenLoaded('commonDiscount')),
            'copan'=>new CopanResource($this->whenLoaded('copan')),
            'delivery_amount'=>$this->delivery_amount,
            'delivery_date'=>$this->delivery_date,
           


        ];
    }
}
