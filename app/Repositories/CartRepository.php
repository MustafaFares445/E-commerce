<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get() : Collection;

    public function add(Product $product , $quantity = 0):Cart;

    public function update(Product $product , $quantity);

    public function delete(string $id);

    public function empty();

    public function total():float;
}
