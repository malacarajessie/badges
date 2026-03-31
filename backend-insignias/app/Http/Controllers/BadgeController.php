<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return response()->json($badges, 200);
    }

    public function userBadges()
    {
        $user = User::find(1);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $badges = $user->badges;

        return response()->json($badges, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'required_points' => 'required|integer',
        ]);

        $badge = Badge::create($validated);
        
        return response()->json([
            'message' => 'Insignia creada con éxito',
            'data' => $badge
        ], 201);
    }

    public function show($id)
    {
        $badge = Badge::find($id);

        if (!$badge) {
            return response()->json(['message' => 'Insignia no encontrada'], 404);
        }

        return response()->json($badge, 200);
    }

    public function update(Request $request, string $id)
    {
       // Método requerido por --api
    }

    public function destroy(string $id)
    {
        // Método requerido por --api
    }
}