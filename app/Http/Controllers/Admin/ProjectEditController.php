<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProyectoAno;
use App\Models\ProyectoImagen;
use App\Models\ProyectoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectEditController extends Controller
{
    public function index()
    {
        $anos          = ProyectoAno::where('id_pagina', 5)->orderByDesc('ano')->get();
        $categoriesObj = ProyectoCategoria::orderBy('orden')->get();
        $categories    = $categoriesObj->pluck('nombre')->toArray();
        $activeYear    = $anos->first()?->ano ?? date('Y');

        $images = ProyectoImagen::whereHas('ano', fn($q) => $q->where('id_pagina', 5))
            ->with('categoria')
            ->get()
            ->map(fn($img) => (object)[
                'id'          => $img->id_imagen,
                'year'        => $img->ano->ano,
                'category'    => $img->categoria->nombre,
                'titulo'      => $img->titulo,
                'image_path'  => $img->image_path,
                'description' => $img->description,
                'event_date'  => $img->event_date,
            ]);

        $yearSubtitles  = $anos->pluck('subtitulo', 'ano')->toArray();
        $yearVisibility = $anos->pluck('visible',   'ano')->toArray();
        $yearsArr       = $anos->pluck('ano')->map(fn($y) => (string)$y)->toArray();

        return view('admin.pages.projects_edit', compact(
            'yearsArr', 'categories', 'categoriesObj', 'images',
            'activeYear', 'yearSubtitles', 'yearVisibility'
        ));
    }

    public function yearUpdate(Request $request)
    {
        $request->validate([
            'year'      => 'required|integer',
            'subtitulo' => 'nullable|string|max:255',
            'visible'   => 'boolean',
        ]);

        $ano = ProyectoAno::where('id_pagina', 5)
                        ->where('ano', $request->year) // ← sin ñ
                        ->firstOrFail();

        $ano->update([
            'subtitulo' => $request->subtitulo,
            'visible'   => $request->visible,
        ]);

        return response()->json(['ok' => true]);
    }

    public function yearStore(Request $request)
    {
        $request->validate(['year' => 'required|integer|min:2000']);

        $ano = ProyectoAno::firstOrCreate(
            ['id_pagina' => 5, 'ano' => $request->year], // ← sin ñ
            ['visible' => true]
        );

        return response()->json(['ok' => true, 'ano' => $ano->ano]);
    }

public function yearDestroy(Request $request)
{
    try {
        $ano = ProyectoAno::where('id_pagina', 5)
                          ->where('ano', $request->year)
                          ->firstOrFail();

        foreach ($ano->imagenes as $img) {
            if ($img->image_path) Storage::disk('public')->delete($img->image_path);
        }

        $ano->delete();
        return response()->json(['ok' => true]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line'  => $e->getLine(),
        ], 500);
    }
}

    // Subir imagen
    public function imageStore(Request $request)
    {
        try {
            $request->validate([
                'year'        => 'required|integer',
                'category'    => 'required|string',
                'titulo'      => 'required|string|max:150',
                'description' => 'required|string',
                'event_date'  => 'required|date',
                'image'       => 'required|image|max:5120',
            ]);

            $ano = ProyectoAno::where('id_pagina', 5)
                            ->where('ano', $request->year) // ← sin ñ
                            ->firstOrFail();

            $cat = ProyectoCategoria::where('nombre', $request->category)->firstOrFail();

            $path = $request->file('image')->store('proyectos', 'public');

            $img = ProyectoImagen::create([
                'id_ano'       => $ano->id_ano,  // ← sin ñ
                'id_categoria' => $cat->id_categoria,
                'titulo'       => $request->titulo,
                'image_path'   => $path,
                'description'  => $request->description,
                'event_date'   => $request->event_date,
            ]);

            return response()->json(['ok' => true, 'id' => $img->id_imagen]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ], 500);
        }
    }

    // Editar imagen
    public function imageUpdate(Request $request, $id)
    {
        $img = ProyectoImagen::findOrFail($id);

        $request->validate([
            'category'    => 'required|string',
            'titulo'      => 'required|string|max:150',
            'description' => 'required|string',
            'event_date'  => 'required|date',
        ]);

        $cat = ProyectoCategoria::where('nombre', $request->category)->firstOrFail();

        if ($request->hasFile('image')) {
            if ($img->image_path) Storage::disk('public')->delete($img->image_path);
            $img->image_path = $request->file('image')->store('proyectos', 'public');
        }

        $img->update([
            'id_categoria' => $cat->id_categoria,
            'titulo'       => $request->titulo,
            'description'  => $request->description,
            'event_date'   => $request->event_date,
            'image_path'   => $img->image_path,
        ]);

        return response()->json(['ok' => true]);
    }

    // Eliminar imagen
    public function imageDestroy($id)
    {
        $img = ProyectoImagen::findOrFail($id);
        if ($img->image_path) Storage::disk('public')->delete($img->image_path);
        $img->delete();
        return response()->json(['ok' => true]);
    }

    // Guardar categoría nueva
    public function categoryStore(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $cat = ProyectoCategoria::firstOrCreate(['nombre' => $request->nombre]);
        return response()->json(['ok' => true, 'id' => $cat->id_categoria]);
    }

    // Eliminar categoría
    public function categoryDestroy($id)
    {
        ProyectoCategoria::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}