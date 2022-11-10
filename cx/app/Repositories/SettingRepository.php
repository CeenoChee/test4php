<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SettingRepository extends EloquentRepository
{
    public function createOrUpdate(array $request): Setting
    {
        return $this->model->updateOrCreate(
            ['key' => array_key_first($request)],
            ['value' => reset($request)],
        );
    }

    public function createOrUpdateMany(array $request): Collection
    {
        $settings = collect();

        foreach ($request as $key => $value) {
            $settings->push($this->createOrUpdate([$key => $value]));
        }

        return $settings;
    }

    public function deleteByKey(string $key): void
    {
        $setting = $this->model
            ->where('key', $key)
            ->first();

        if ($setting instanceof Model) {
            $setting->delete();
        }
    }

    public function deleteManyByKey(array $keys): void
    {
        foreach ($keys as $key) {
            $this->deleteByKey($key);
        }
    }

    public function getByKey(string $key): ?Setting
    {
        return $this->model
            ->where('key', $key)
            ->first();
    }

    public function getValueByKey(string $key): ?string
    {
        return $this->model
            ->where('key', $key)
            ->value('value');
    }

    protected function setModel()
    {
        $this->model = new Setting();
    }
}
