<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\CommunicationsMethodsEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $orders = Order::whereStatus(OrderStatusEnum::New)
            ->with('product')
            ->orderByDesc('id')
            ->paginate($perPage, page: $page);

        $communicationMethods = [];
        foreach (CommunicationsMethodsEnum::cases() as $communicationMethod) {
            $communicationMethods[$communicationMethod->value] = $communicationMethod->label();
        }

        return Inertia::render('Order/Index', [
            'orders' => $orders,
            'communicationMethods' => $communicationMethods,
        ]);
    }

    public function complete(Order $order): RedirectResponse
    {
        $order->update(['status' => OrderStatusEnum::Completed]);

        return redirect()->route('orders.index');
    }
}
