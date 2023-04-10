<?php

namespace App\Helpers;

class ClientIp
{
    public function getClientIp(): string
    {
        return $_SERVER['HTTP_X_CLIENT_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function getAllowedIps(): array
    {
        $ips = config('ips.allowed_ips');
        if (empty($ips)) {
            return [];
        }

        $allowed = [];
        foreach (explode(',', $ips) as $ip) {
            $allowed[] = $this->getIpsFromRange($ip);
        }

        return $allowed;
    }

    public function isPrivate(string $ipAddress): bool
    {
        $ipAddress = trim($ipAddress);
        if (empty($ipAddress)) {
            return true;
        }

        if ($ipAddress === '0.0.0.0') {
            return true;
        }

        if (filter_var(
                $ipAddress,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            ) === false) {
            return true;
        }

        $long_ip = ip2long($ipAddress);
        if ($long_ip === -1) {
            return false;
        }

        $pri_addresses = ['127.0.0.0|127.255.255.255'];
        foreach ($pri_addresses as $pri_addr) {
            [$start, $end] = explode('|', $pri_addr);

            // IF IS PRIVATE
            if ($long_ip >= ip2long($start) && $long_ip <= ip2long($end)) {
                return true;
            }
        }

        return false;
    }

    private function getIpsFromRange(string $range): array
    {
        $range = trim($range);
        if (empty($range)) {
            return ['0.0.0.0'];
        }

        if (!str_contains($range, '|')) {
            return $this->getIpRange($range);
        }

        $ipList = [];
        foreach (explode('|', $range) as $item) {
            $ipList[] = $this->getIpRange($item);
        }

        return $ipList;
    }

    private function getIpRange(string $range): array
    {
        if (!str_contains($range, '/')) {
            return [$range];
        }

        $ipList = [];
        [$ip, $cidr] = explode('/', $range);
        $cidr = (int) $cidr;
        $ip_count = (1 << (32 - $cidr)) - 1;
        $firstIp = (ip2long($ip) & ((-1 << (32 - $cidr))));
        for ($i = 0; $i < $ip_count; $i++) {
            $ipList[] = long2ip($firstIp + $i);
        }

        return $ipList;
    }
}
