<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Variacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariacionesController extends Controller
{
    public function index()
    {
        $variaciones = Variacion::with('categorias', 'producto')->get();
        return response()->json($variaciones);
    }

    public function getProductosLinea()
    {
        $variaciones = Variacion::select(
            'productos.nombre as nombre_producto',
            'categorias.nombre as nombre_categoria',
            DB::raw('MIN(variaciones.id) as id_producto')
        )
            ->join('variacion_categoria', 'variaciones.id', '=', 'variacion_categoria.variacion_id')
            ->join('categorias', 'variacion_categoria.categoria_id', '=', 'categorias.id')
            ->join('productos', 'variaciones.producto_id', '=', 'productos.id')
            ->where('categorias.nombre', 'Productos de linea')
            ->groupBy('productos.nombre', 'categorias.nombre')
            ->get();

        return response()->json($variaciones);
    }

    public function getProductosEspeciales()
    {
        $variaciones = Variacion::select('productos.id as id_producto', 'productos.nombre as nombre_producto', 'categorias.nombre as nombre_categoria')
            ->join('variacion_categoria', 'variaciones.id', '=', 'variacion_categoria.variacion_id')
            ->join('categorias', 'variacion_categoria.categoria_id', '=', 'categorias.id')
            ->join('productos', 'variaciones.producto_id', '=', 'productos.id')
            ->where('categorias.nombre', 'Productos Especiales')
            ->groupBy('productos.nombre', 'categorias.nombre', 'productos.id')
            ->get();

        return response()->json($variaciones);
    }


    public function obtenerInformacionProducto($variacionId)
    {
        $variacion = Variacion::findOrFail($variacionId);
        $idProducto = $variacion->producto_id;
        $nombre_producto = Producto::findOrFail($idProducto)->nombre;


        $variaciones = Variacion::where('producto_id', $idProducto)->get();

        $medidas = $variaciones->groupBy('nombre')->map(function ($variaciones) {
            return $variaciones->pluck('medida')->unique();
        });

        $aplicaciones = $variaciones->flatMap(function ($variacion) {
            return $variacion->aplicaciones;
        })->unique('id');

        foreach ($aplicaciones as $aplicacion) {
            $aplicacion->nombre = ucfirst(mb_strtolower($aplicacion->nombre, 'UTF-8'));
        }

        $nombres_aplicaciones = $aplicaciones->pluck('nombre');



        return response()->json([
            'nombre_producto' => $nombre_producto,
            'medidas' => $medidas->flatten()->values(),
            'aplicaciones' => $nombres_aplicaciones,

        ]);
    }

    public function obtenerNombresProducto($categoriaNombre)
    {

        $categoriaId = Categoria::where('nombre', $categoriaNombre)->first();
        $variacionesPorProducto = Variacion::select(
            'productos.nombre',
            DB::raw('MIN(variaciones.id) as id_producto')
        )
            ->join('productos', 'variaciones.producto_id', '=', 'productos.id')
            ->join('variacion_categoria', 'variaciones.id', '=', 'variacion_categoria.variacion_id')
            ->join('categorias', 'variacion_categoria.categoria_id', '=', 'categorias.id')
            ->where('categorias.id', $categoriaId->id) 
            ->groupBy('productos.nombre')
            ->get();


        return response()->json($variacionesPorProducto);
    }


    public function obtenerColorProducto($nombreProducto)
    {

        $producto_id = Producto::where('nombre', $nombreProducto)->first();
        $variacion_id = Variacion::where('producto_id', $producto_id->id)->first();

        $nombreProducto = Variacion::select('producto_id')
            ->where('id', $variacion_id->id)
            ->value('producto_id');

        $coloresProductos = Variacion::where('producto_id', $nombreProducto)
            ->groupBy('color')
            ->distinct('color')
            ->pluck('color');


        return response()->json($coloresProductos);
    }

    public function obtenerMedidasProducto(Request $request)
    {

        $nombreProducto = $request->query('productoId');
        $variacionColor = $request->query('color');

        $producto_id = Producto::where('nombre', $nombreProducto)->first();
        $variacionId = Variacion::where('producto_id', $producto_id->id)->first();

        $variacion = Variacion::findOrFail($variacionId->id);
        $idProducto = $variacion->producto_id;
        $nombreVariacion = $variacion->nombre;

        $variaciones = Variacion::where('producto_id', $idProducto)
            ->where('color', $variacionColor)
            ->get();

        $medidas = $variaciones->groupBy('nombre')->map(function ($variaciones) {
            return $variaciones->pluck('medida')->unique();
        });
        $medidas = $medidas->get($nombreVariacion, collect());

        return response()->json($medidas);
    }

    public function obtenerUnidadVenta(Request $request)
    {

        $nombreProducto = $request->query('productoId');
        $variacionColor = $request->query('color');
        $variacionMedida = $request->query('medida');

        
        $producto_id = Producto::where('nombre', $nombreProducto)->first();
        $variacionId = Variacion::where('producto_id', $producto_id->id)->first();


        $idProducto = Variacion::where('id', $variacionId->id)->value('producto_id');
        $variaciones = Variacion::where('producto_id', $idProducto)
        ->where('color', $variacionColor)
        ->where('medida', $variacionMedida)
        ->first();
        

        $unidadesVenta = $variaciones->unidadesVenta()->pluck('unidad');


        return response()->json($unidadesVenta);
    }
}