<?php

namespace App\Libs;

use App\Models\Manufacturer;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class Category
{
    private $productCategory;
    private $children = [];
    private $numProducts;

    public function __construct()
    {
        $this->init();
    }

    public function all()
    {
        return array_values($this->productCategory);
    }

    public function exists($id)
    {
        if (empty($id)) {
            return false;
        }

        return array_key_exists($id, $this->productCategory);
    }

    public function get($id)
    {
        return $this->exists($id) ? $this->productCategory[$id] : null;
    }

    public function getParent($id)
    {
        $productCategory = $this->get($id);
        if ($productCategory) {
            return $this->get($productCategory->FelsoTermekfaLevel_ID);
        }

        return null;
    }

    public function getParents($id)
    {
        $parents = [];
        while ($parent = $this->getParent($id)) {
            $parents[] = $parent;
            $id = $parent->TermekfaLevel_ID;
        }

        return array_reverse($parents);
    }

    public function getPath($id)
    {
        $path = $this->getParents($id);
        $path[] = $this->get($id);

        return $path;
    }

    public function getFullName($id)
    {
        $fullName = [];
        foreach ($this->getPath($id) as $element) {
            if ($element) {
                $forditas = $element->trans;
                if ($forditas) {
                    $fullName[] = $forditas->Nev;
                }
            }
        }

        return implode('/', $fullName);
    }

    public function getMain($id)
    {
        $parents = $this->getParents($id);

        return isset($parents[0]) ? $parents[0] : null;
    }

    public function hasChild($id)
    {
        return array_key_exists($id, $this->children);
    }

    public function getChildren($id)
    {
        $children = [];
        if ($this->hasChild($id)) {
            foreach ($this->children[$id] as $childId) {
                $children[] = $this->get($childId);
            }
        }

        return $children;
    }

    public function getRoots()
    {
        return $this->getChildren(0);
    }

    public function isEmpty($id)
    {
        if ($this->numProducts === null) {
            $this->loadNumProducts();
        }

        if (array_key_exists($id, $this->numProducts)) {
            return false;
        }

        foreach ($this->getChildren($id) as $productCategory) {
            if (! $this->isEmpty($productCategory->TermekfaLevel_ID)) {
                return false;
            }
        }

        return true;
    }

    protected function init()
    {
        foreach (ProductCategory::with('trans')->orderBy('Sorrend')->get() as $productCategory) {
            $this->productCategory[$productCategory->TermekfaLevel_ID] = $productCategory;
            $this->children[$productCategory->FelsoTermekfaLevel_ID][] = $productCategory->TermekfaLevel_ID;
        }
    }

    private function loadNumProducts()
    {
        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds();

        $this->numProducts = [];

        $sql = '
				SELECT
					tfl.TermekfaLevel_ID,
					COUNT(ttf.TermekfaLevel_ID) AS num
				FROM termekfa_level tfl
				INNER JOIN termek_termekfa ttf ON ttf.TermekfaLevel_ID = tfl.TermekfaLevel_ID
				INNER JOIN termek t ON t.Termek_ID = ttf.Termek_ID
				WHERE t.Aktiv = 1 AND t.Lathato = 1
                AND t.Gyarto_ID NOT IN ' . ($blacklistedManufacturerIds->count() ? '(' . $blacklistedManufacturerIds->implode(',') . ')' : '(-1)') . '
				GROUP BY tfl.TermekfaLevel_ID
			';

        foreach (DB::select($sql) as $row) {
            $this->numProducts[$row->TermekfaLevel_ID] = $row->num;
        }
    }
}
