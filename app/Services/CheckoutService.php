<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Order;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    /**
     * Create an order while preserving inventory and balance consistency.
     *
     * @param array<int, int> $quantities
     */
    public function purchase(User $user, array $quantities, string $address): Order
    {
        return DB::transaction(function () use ($user, $quantities, $address): Order {
            $plants = Plant::query()
                ->whereKey(array_keys($quantities))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($plants->count() !== count($quantities)) {
                throw ValidationException::withMessages(['cart' => __('controller.cart_contains_unavailable_plants')]);
            }

            $total = $this->total($plants, $quantities);
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->getId());

            if ($lockedUser->getBalance() < $total) {
                throw ValidationException::withMessages(['cart' => __('controller.not_enough_balance')]);
            }

            foreach ($plants as $plant) {
                $quantity = $quantities[$plant->getId()];
                if ($plant->getStock() < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => __('controller.insufficient_stock', ['plant' => $plant->getName()]),
                    ]);
                }
            }

            $order = new Order();
            $order->setUserId($lockedUser->getId());
            $order->setAddress($address);
            $order->setTotal($total);
            $order->save();

            foreach ($plants as $plant) {
                $quantity = $quantities[$plant->getId()];
                $plant->setStock($plant->getStock() - $quantity);
                $plant->save();

                $item = new Item();
                $item->setQuantity($quantity);
                $item->setPrice($plant->getPrice());
                $item->setPlantId($plant->getId());
                $item->setOrderId($order->getId());
                $item->save();
            }

            $lockedUser->setBalance($lockedUser->getBalance() - $total);
            $lockedUser->save();

            return $order;
        });
    }

    /** @param array<int, int> $quantities */
    public function total(Collection $plants, array $quantities): int
    {
        return $plants->sum(fn (Plant $plant): int => $plant->getPrice() * $quantities[$plant->getId()]);
    }
}
