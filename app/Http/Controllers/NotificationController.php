<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /** GET /api/notifications/count */
    public function count()
    {
        $userId = session('user_id');
        if (!$userId) return response()->json(['count' => 0]);

        $count = Notification::where('id_usuario', $userId)
                              ->where('leido', 0)
                              ->count();

        return response()->json(['count' => $count]);
    }

    /** GET /api/notifications/list */
    public function list()
    {
        $userId = session('user_id');
        if (!$userId) return response()->json(['notifications' => []]);

        $notificaciones = Notification::where('id_usuario', $userId)
            ->orderByRaw('`leido` ASC')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($n) {
                return [
                    'id'            => $n->id_notificacion,
                    'title'         => $n->titulo,
                    'message'       => $n->mensaje,
                    'read'          => (bool) $n->leido,
                    'id_formulario' => $n->id_formulario,
                    'time'          => Carbon::parse($n->created_at)
                                             ->locale('es')
                                             ->diffForHumans(),
                ];
            });

        return response()->json(['notifications' => $notificaciones]);
    }

    /** POST /api/notifications/{id}/read */
    public function markRead($id)
    {
        $userId = session('user_id');
        if (!$userId) return response()->json(['success' => false]);

        $updated = Notification::where('id_notificacion', $id)
                                ->where('id_usuario', $userId)
                                ->update(['leido' => 1]);

        return response()->json(['success' => (bool) $updated]);
    }

    /** POST /api/notifications/read-all */
    public function markAllRead()
    {
        $userId = session('user_id');
        if (!$userId) return response()->json(['success' => false]);

        Notification::where('id_usuario', $userId)
                    ->where('leido', 0)
                    ->update(['leido' => 1]);

        return response()->json(['success' => true]);
    }

    /** DELETE /api/notifications/clear-all */
    public function clearAll()
    {
        $userId = session('user_id');
        if (!$userId) return response()->json(['success' => false]);

        Notification::where('id_usuario', $userId)->delete();

        return response()->json(['success' => true]);
    }
}