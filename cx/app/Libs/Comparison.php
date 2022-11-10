<?php

namespace App\Libs;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Comparison
{
    public function getIds()
    {
        return Session::get('comparison', []);
    }

    public function exists($id): bool
    {
        return in_array($id, $this->getIds());
    }

    public function set($id, $value)
    {
        $comparison = $this->getIds();
        if ($value && ! $this->exists($id)) {
            $comparison[] = (int) $id;
        }

        if (! $value && $this->exists($id)) {
            unset($comparison[array_search($id, $comparison)]);
        }

        Session::put('comparison', $comparison);
    }

    public function delete($id)
    {
        $this->set($id, false);
    }

    public function count(): int
    {
        return count($this->getIds());
    }

    public function renderBox(): string
    {
        return view('pages.comparison.includes.compare-all-button', [
            'count' => $this->count(),
            'active' => $this->count() > 0,
            'content' => $this->renderBoxContent(),
        ])->render();
    }

    public function renderBoxContent(): string
    {
        $comparisonIds = $this->getIds();
        if (count($comparisonIds)) {
            $comparisons = Product::whereIn('Termek_ID', $comparisonIds)->get();
        } else {
            $comparisons = [];
        }

        return view('pages.comparison.includes.box-content', [
            'products' => $comparisons,
        ])->render();
    }
}
