<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivamos llaves foráneas para poder limpiar las tablas sin errores
        Schema::disableForeignKeyConstraints();
        
        // Limpiamos las tablas antes de llenarlas (para no duplicar si corres el seed 2 veces)
        DB::table('productos')->truncate();
        DB::table('categorias')->truncate();

        // --------------------------------------------------------
        // 1. INSERTAR CATEGORÍAS
        // --------------------------------------------------------
        $categorias = [
            ['id' => 1, 'nombre' => 'Entradas', 'descripcion' => 'Aperitivos para comenzar'],
            ['id' => 2, 'nombre' => 'Combos Desayuno', 'descripcion' => 'Incluye café o jugo'],
            ['id' => 3, 'nombre' => 'Chilaquiles', 'descripcion' => 'Rojos, Verdes, Suizos o Poblanos'],
            ['id' => 4, 'nombre' => 'Huevos y Omelettes', 'descripcion' => 'Al gusto, rancheros, divorciados'],
            ['id' => 5, 'nombre' => 'Enchiladas', 'descripcion' => 'Orden de 3 piezas'],
            ['id' => 6, 'nombre' => 'Lo Saludable', 'descripcion' => 'Opciones ligeras y frutas'],
            ['id' => 7, 'nombre' => 'Los Favoritos', 'descripcion' => 'Waffles, Hot Cakes y Pan Francés'],
            ['id' => 8, 'nombre' => 'Para los Nenes', 'descripcion' => 'Menú infantil'],
            ['id' => 9, 'nombre' => 'Bebidas', 'descripcion' => 'Frías y calientes'],
            ['id' => 10, 'nombre' => 'Comidas y Caldos', 'descripcion' => 'Sopas y platos fuertes'],
            ['id' => 11, 'nombre' => 'Antojitos Mexicanos', 'descripcion' => 'Flautas, Tostadas, Gorditas y Tacos'],
            ['id' => 12, 'nombre' => 'Mariscos', 'descripcion' => 'Camarones y Pescados'],
            ['id' => 13, 'nombre' => 'Carnes y Aves', 'descripcion' => 'Pechugas, Costillas y Cortes'],
            ['id' => 14, 'nombre' => 'Hamburguesas', 'descripcion' => 'Nuestras especialidades'],
            ['id' => 15, 'nombre' => 'Extras', 'descripcion' => 'Ingredientes adicionales'],
        ];

        foreach ($categorias as $cat) {
            DB::table('categorias')->insert([
                'id' => $cat['id'],
                'nombre' => $cat['nombre'],
                'descripcion' => $cat['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --------------------------------------------------------
        // 2. INSERTAR PRODUCTOS
        // --------------------------------------------------------
        $productos = [
            // CAT 1: ENTRADAS
            ['nombre' => 'Guacamole', 'precio' => 75.00, 'descripcion' => 'Entrada clásica', 'categoria_id' => 1],
            ['nombre' => 'Quesito Fresco', 'precio' => 45.00, 'descripcion' => null, 'categoria_id' => 1],
            ['nombre' => 'Queso Fundido con Chorizo', 'precio' => 110.00, 'descripcion' => null, 'categoria_id' => 1],
            ['nombre' => 'Picaduras', 'precio' => 25.00, 'descripcion' => null, 'categoria_id' => 1],

            // CAT 2: COMBOS
            ['nombre' => 'Desayuno Don Nacho', 'precio' => 170.00, 'descripcion' => 'Carne asada a la leña, chilaquiles, frijol y huevo', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Escuinapense', 'precio' => 170.00, 'descripcion' => 'Machaca de camarón, chilaquiles, frijol y huevo', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Sinaloense', 'precio' => 170.00, 'descripcion' => 'Chicharrón, chilaquiles, huevo y frijol', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Campestre', 'precio' => 170.00, 'descripcion' => 'Machaca, chilaquiles, frijol y tamal de elote', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Doña Andrea', 'precio' => 170.00, 'descripcion' => 'Calabacitas a la mexicana, chilaquiles, frijol y huevo', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Marino', 'precio' => 170.00, 'descripcion' => 'Marlin, chilaquiles, frijol y huevo', 'categoria_id' => 2],
            ['nombre' => 'Desayuno Saludable', 'precio' => 170.00, 'descripcion' => 'Omelette de claras, ensalada y chilaquiles', 'categoria_id' => 2],

            // CAT 3: CHILAQUILES
            ['nombre' => 'Orden de Chilaquiles', 'precio' => 100.00, 'descripcion' => 'Salsas a elegir: Rojos, Verdes, Suizos, Poblanos', 'categoria_id' => 3],

            // CAT 4: HUEVOS
            ['nombre' => 'Huevos al Gusto', 'precio' => 90.00, 'descripcion' => 'Ingrediente a elegir: jamón, salchicha, machaca, chorizo, tocino, a la mexicana, espinaca, champiñones', 'categoria_id' => 4],
            ['nombre' => 'Huevos Divorciados', 'precio' => 95.00, 'descripcion' => null, 'categoria_id' => 4],
            ['nombre' => 'Huevos Rancheros', 'precio' => 95.00, 'descripcion' => null, 'categoria_id' => 4],
            ['nombre' => 'Omelette al Gusto', 'precio' => 120.00, 'descripcion' => 'Con queso e ingrediente a elegir', 'categoria_id' => 4],

            // CAT 5: ENCHILADAS
            ['nombre' => 'Orden Enchiladas (3 pzas)', 'precio' => 120.00, 'descripcion' => 'Opciones: Mexicanas, Suizas, Enmoladas, Verdes, Poblanas', 'categoria_id' => 5],

            // CAT 6: SALUDABLE
            ['nombre' => 'Avocado Toast', 'precio' => 110.00, 'descripcion' => 'Pan tostado con aguacate', 'categoria_id' => 6],
            ['nombre' => 'Omelette de Claras', 'precio' => 125.00, 'descripcion' => 'Con queso y vegetales, acompañado de ensalada', 'categoria_id' => 6],
            ['nombre' => 'Plato con Frutas', 'precio' => 85.00, 'descripcion' => 'Fruta de temporada', 'categoria_id' => 6],
            ['nombre' => 'Yogurth con Fruta', 'precio' => 110.00, 'descripcion' => null, 'categoria_id' => 6],

            // CAT 7: FAVORITOS
            ['nombre' => 'Waffles', 'precio' => 90.00, 'descripcion' => 'Toppings disponibles: Fresa, Plátano, Durazno', 'categoria_id' => 7],
            ['nombre' => 'Hot Cakes (2 piezas)', 'precio' => 90.00, 'descripcion' => 'Toppings disponibles: Fresa, Plátano, Durazno', 'categoria_id' => 7],
            ['nombre' => 'Pan Francés', 'precio' => 90.00, 'descripcion' => 'Toppings disponibles: Fresa, Plátano, Durazno', 'categoria_id' => 7],

            // CAT 8: NIÑOS
            ['nombre' => 'Hot Cake Kids', 'precio' => 80.00, 'descripcion' => 'Con huevo y salchicha', 'categoria_id' => 8],
            ['nombre' => 'Nuggets con Papas', 'precio' => 80.00, 'descripcion' => null, 'categoria_id' => 8],
            ['nombre' => 'Hamburguesa Kids', 'precio' => 80.00, 'descripcion' => null, 'categoria_id' => 8],
            ['nombre' => 'Quesadilla con Papas', 'precio' => 80.00, 'descripcion' => null, 'categoria_id' => 8],

            // CAT 9: BEBIDAS
            ['nombre' => 'Licuado (1/2 Lt)', 'precio' => 40.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Licuado (1 Lt)', 'precio' => 60.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Chocomilk (1/2 Lt)', 'precio' => 40.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Chocomilk (1 Lt)', 'precio' => 60.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Café de Olla', 'precio' => 45.00, 'descripcion' => 'Refill +$15', 'categoria_id' => 9],
            ['nombre' => 'Café Americano', 'precio' => 45.00, 'descripcion' => 'Incluye refill', 'categoria_id' => 9],
            ['nombre' => 'Limonada (1/2 Lt)', 'precio' => 40.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Limonada (1 Lt)', 'precio' => 60.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Naranjada (1/2 Lt)', 'precio' => 40.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Naranjada (1 Lt)', 'precio' => 60.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Limonada Frutos Rojos (1/2 Lt)', 'precio' => 40.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Limonada Frutos Rojos (1 Lt)', 'precio' => 60.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Agua Fresca (1/2 Lt)', 'precio' => 30.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Agua Fresca (1 Lt)', 'precio' => 50.00, 'descripcion' => null, 'categoria_id' => 9],
            ['nombre' => 'Agua Natural (1 Lt)', 'precio' => 30.00, 'descripcion' => 'Embotellada', 'categoria_id' => 9],
            ['nombre' => 'Refresco', 'precio' => 35.00, 'descripcion' => null, 'categoria_id' => 9],

            // CAT 10: COMIDAS
            ['nombre' => 'Sopa de Tortilla', 'precio' => 110.00, 'descripcion' => null, 'categoria_id' => 10],
            ['nombre' => 'Caldo de Pollo', 'precio' => 100.00, 'descripcion' => null, 'categoria_id' => 10],
            ['nombre' => 'Caldo Tlalpeño', 'precio' => 120.00, 'descripcion' => null, 'categoria_id' => 10],
            ['nombre' => 'Mole', 'precio' => 125.00, 'descripcion' => null, 'categoria_id' => 10],

            // CAT 11: ANTOJITOS
            ['nombre' => 'Flauta (Pieza)', 'precio' => 45.00, 'descripcion' => 'Carne, pollo o camarón', 'categoria_id' => 11],
            ['nombre' => 'Orden Flautas (3 piezas)', 'precio' => 120.00, 'descripcion' => 'Carne, pollo o camarón', 'categoria_id' => 11],
            ['nombre' => 'Tostada (Pieza)', 'precio' => 45.00, 'descripcion' => 'Carne, pollo o camarón', 'categoria_id' => 11],
            ['nombre' => 'Orden Tostadas (3 piezas)', 'precio' => 120.00, 'descripcion' => 'Carne, pollo o camarón', 'categoria_id' => 11],
            ['nombre' => 'Gordita (Pieza)', 'precio' => 45.00, 'descripcion' => 'Pollo o asado', 'categoria_id' => 11],
            ['nombre' => 'Orden Gorditas (3 piezas)', 'precio' => 120.00, 'descripcion' => 'Pollo o asado', 'categoria_id' => 11],
            ['nombre' => 'Taco Dorado Camarón (Pieza)', 'precio' => 45.00, 'descripcion' => null, 'categoria_id' => 11],
            ['nombre' => 'Orden Tacos Dorados (3 piezas)', 'precio' => 120.00, 'descripcion' => null, 'categoria_id' => 11],
            ['nombre' => 'Taco Gobernador', 'precio' => 60.00, 'descripcion' => 'Pieza individual', 'categoria_id' => 11],
            ['nombre' => 'Taco Capeado (Pieza)', 'precio' => 45.00, 'descripcion' => 'Camarón o pescado', 'categoria_id' => 11],
            ['nombre' => 'Orden Tacos Capeados (3 piezas)', 'precio' => 120.00, 'descripcion' => 'Camarón o pescado', 'categoria_id' => 11],

            // CAT 12: MARISCOS
            ['nombre' => 'Camarones al Gusto', 'precio' => 160.00, 'descripcion' => 'Empanizados, coco, mojo de ajo, a la diabla. Con arroz y ensalada', 'categoria_id' => 12],
            ['nombre' => 'Filete de Pescado', 'precio' => 150.00, 'descripcion' => 'Plancha, empanizado, mojo de ajo. Con arroz y ensalada', 'categoria_id' => 12],

            // CAT 13: CARNES
            ['nombre' => 'Pechuga Rellena', 'precio' => 145.00, 'descripcion' => null, 'categoria_id' => 13],
            ['nombre' => 'Pechuga Empanizada', 'precio' => 140.00, 'descripcion' => null, 'categoria_id' => 13],
            ['nombre' => 'Pechuga a la Plancha', 'precio' => 135.00, 'descripcion' => null, 'categoria_id' => 13],
            ['nombre' => 'Costillitas', 'precio' => 125.00, 'descripcion' => 'Con arroz y frijol', 'categoria_id' => 13],
            ['nombre' => 'Chuleta en Salsa Verde', 'precio' => 125.00, 'descripcion' => 'Con arroz y frijol', 'categoria_id' => 13],
            ['nombre' => 'Asado', 'precio' => 130.00, 'descripcion' => null, 'categoria_id' => 13],
            ['nombre' => 'Bistec Ranchero', 'precio' => 130.00, 'descripcion' => 'Con arroz y frijol', 'categoria_id' => 13],
            ['nombre' => 'Milanesa a la Plancha', 'precio' => 130.00, 'descripcion' => 'Con arroz y frijol', 'categoria_id' => 13],
            ['nombre' => 'Milanesa Empanizada', 'precio' => 140.00, 'descripcion' => 'Con arroz y frijol', 'categoria_id' => 13],

            // CAT 14: HAMBURGUESAS
            ['nombre' => 'Hamburguesa Tradicional', 'precio' => 95.00, 'descripcion' => null, 'categoria_id' => 14],
            ['nombre' => 'Hamburguesa Don Nacho', 'precio' => 140.00, 'descripcion' => 'Especial de la casa', 'categoria_id' => 14],
            ['nombre' => 'Hamburguesa Mar y Tierra', 'precio' => 165.00, 'descripcion' => null, 'categoria_id' => 14],
            ['nombre' => 'Hamburguesa de Pollo', 'precio' => 134.00, 'descripcion' => null, 'categoria_id' => 14],

            // CAT 15: EXTRAS
            ['nombre' => 'Extra Pollo Desmenuzado', 'precio' => 30.00, 'descripcion' => null, 'categoria_id' => 15],
            ['nombre' => 'Extra Pollo a la Plancha', 'precio' => 50.00, 'descripcion' => null, 'categoria_id' => 15],
            ['nombre' => 'Extra Carne Asada', 'precio' => 50.00, 'descripcion' => null, 'categoria_id' => 15],
            ['nombre' => 'Extra Huevo', 'precio' => 15.00, 'descripcion' => null, 'categoria_id' => 15],
            ['nombre' => 'Refill Café de Olla', 'precio' => 15.00, 'descripcion' => null, 'categoria_id' => 15],
        ];

        foreach ($productos as $prod) {
            DB::table('productos')->insert([
                'nombre' => $prod['nombre'],
                'precio' => $prod['precio'],
                'descripcion' => $prod['descripcion'],
                'categoria_id' => $prod['categoria_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Reactivamos protección
        Schema::enableForeignKeyConstraints();
    }
}