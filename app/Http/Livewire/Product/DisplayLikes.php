<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class DisplayLikes extends Component
{
    public $count = 0;
    public $prodid;
    public $product;
    public $liked = false;

    public function mount($likes, $prodid)
    {
        $this->count = $likes;
        $this->prodid = $prodid;
    }

    public function render()
    {
        return view('livewire.product.display-likes');
    }

    public function addCount()
    {
        $product = Product::find($this->prodid);
        $this->count = $this->count + 1;
        $product->likes = $this->count;
        $product->save();
        $this->liked = true;
    }

    public function minusCount()
    {
        $product = Product::find($this->prodid);
        if ($this->count > 0) {
            $this->count = $this->count - 1;
            $product->likes = $this->count;
            $product->save();
        }
        $this->liked = false;
    }
}
