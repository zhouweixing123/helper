<?php

namespace Zwx\Helper;

class Helper
{
    /**
     * 校验ip是否合法
     * @param string $ip 需要校验的IP地址
     * @return boolean
     */
    public static function FilterCheckIp(string $ip): bool
    {
        if (empty($ip)) return false;
        if (filter_var($ip, FILTER_VALIDATE_IP)) return true;
        return false;
    }

    /**
     * 校验是否是合法的ipv4地址
     * @param string $ip 需要校验的ip地址
     * @param bool $privateIp 是否需要排除私有ip地址
     * @return boolean
     */
    public static function FilterCheckIpv4(string $ip, bool $privateIp = false): bool
    {
        if (empty($ip)) return false;
        if ($privateIp) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) return true;
            return false;
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return true;
        return false;
    }

    /**
     * 校验是否是合法的ipv6地址
     * @param string $ip 需要校验的ipv6地址
     * @param bool $privateIp 是否需要校验是否是合法的public ipv6地址
     * @return bool
     */
    public static function FilterCheckIpv6(string $ip, bool $privateIp = false): bool
    {
        if (empty($ip)) return false;
        if ($privateIp) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE)) return true;
            return false;
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) return true;
        return false;
    }

    /**
     * 校验url或邮箱是否合法
     * @param string $domain 需要校验的url或邮箱
     * @param int $isEmail 是否是校验邮箱
     * @return bool
     */
    public static function FilterCheckUrlOrEmail(string $domain, int $isEmail = 1): bool
    {
        $type = [
            0 => FILTER_VALIDATE_EMAIL,
            1 => FILTER_VALIDATE_URL
        ];
        if (empty($domain)) return false;
        if (filter_var($domain, $type[$isEmail])) return true;
        return false;
    }

    /**
     * 计算两点直接的距离
     * @param float $latOne 第一个点的维度
     * @param float $lngOne 第一个点的经度
     * @param float $latTwo 第二点的维度
     * @param float $lngTwo 第二个点的经度
     * @param int $unit 单位类型
     * @param int $decimal 保留的小数位数
     * @return float|int
     */
    public static function getDistance(float $latOne, float $lngOne, float $latTwo, float $lngTwo, int $unit = 2, int $decimal = 2): float
    {
        // 地球半径系数
        $earthRadius = 6378.137;

        // 计算维度
        $radLat1 = $latOne * M_PI / 180.0;
        $radLat2 = $latTwo * M_PI / 180.0;

        // 计算经度
        $radLng1 = $lngOne * M_PI / 180.0;
        $radLng2 = $lngTwo * M_PI / 180.0;

        // 计算经度、维度差值
        $radLat = $radLat1 - $radLat2;
        $radLng = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($radLat / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($radLng / 2), 2)));
        $distance = $distance * $earthRadius * 1000;
        if ($unit === 2) $distance /= 1000;
        return round($distance, $decimal);
    }

    /**
     * 根据经纬度获取搜索范围
     * @param float $lat 维度
     * @param float $lng 经度
     * @param float $radius 半径
     * @return float[]|int[]
     */
    public static function getRange(float $lat, float $lng, float $radius): array
    {
        // 计算维度
        $degree = (24901 * 1609) / 360.0;
        $dpmLat = 1 / $degree;
        $radiusLat = $dpmLat * $radius;
        $minLat = $lat - $radiusLat;
        $maxLat = $lat + $radiusLat;

        // 计算经度
        $mpdLng = $degree * cos($lat * (M_PI / 180.0));
        $dpmLng = 1 / $mpdLng;
        $radiusLng = $dpmLng * $radius;
        $minLng = $lng - $radiusLng;
        $maxLng = $lng + $radiusLng;

        // 范围
        return [
            'maxLat' => $maxLat,
            'maxLng' => $maxLng,
            'minLat' => $minLat,
            'minLng' => $minLng
        ];
    }
}
