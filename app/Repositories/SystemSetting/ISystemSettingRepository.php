<?php
namespace App\Repositories\SystemSetting;

interface ISystemSettingRepository {

    public function list();

    public function update(array $data);

    public function findByCode(string $code);

    public function findByCodes(array $codes);
}
