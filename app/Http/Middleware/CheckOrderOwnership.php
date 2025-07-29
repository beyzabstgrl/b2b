<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $orderId = $request->route('id');
        $order = Order::with('user')->find($orderId);

        if (! $order) {
            return response()->json(['message' => 'Sipariş bulunamadı'], 404);
        }

        $user = Auth::user();

        if ($user->role !== 'admin' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Yetkiniz yok'], 403);
        }

        $request->attributes->set('order', $order);

        return $next($request);
    }
}
