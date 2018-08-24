<?php

namespace NovaCards\SystemInformationCard;

use Carbon\Carbon;


/**
 * Description of Class SystemInformation
 *
 * @package
 * @author Tilmann Schaefer <tilmann.schaefer@intellishop.ag>
 * @since 24.08.18
 */
class SystemInformation
{
    public function avg()
    {
        if (is_readable('/proc/loadavg')) {
            return (float)file_get_contents('/proc/loadavg');
        }
        return null;
    }

    public function memory()
    {
        if(is_readable('/proc/meminfo'))
        {
            $content = file_get_contents('/proc/meminfo');
            preg_match('/^MemTotal: \s*(\d*)/m', $content, $matches);
            $total = $this->formatBytes($matches[1] * 1024);
            preg_match('/^MemFree: \s*(\d*)/m', $content, $matches);
            $free = $this->formatBytes($matches[1] * 1024);
            preg_match('/^MemAvailable: \s*(\d*)/m', $content, $matches);
            $used = $this->formatBytes($matches[1] * 1024);

            return [
                'total' => $total,
                'free' => $free,
                'used' => $used
            ];
        }
        return [
            'total' => 0,
            'free' => 0,
            'used' => 0
        ];

    }

    protected function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
         $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function disk()
    {
        $total = disk_total_space(base_path());
        $free = disk_free_space(base_path());
        return [
            'total' => $this->formatBytes($total),
            'free' => $this->formatBytes($free),
            'used' => $this->formatBytes($total - $free)
        ];
    }

    public function uptime()
    {
        if (is_readable('/proc/uptime')) {
            return (float)file_get_contents('/proc/uptime');
        }
        return null;
    }

    public function systemTime(): Carbon
    {
        return Carbon::now();
    }
}