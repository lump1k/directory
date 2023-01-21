<?php


namespace Lump1k\Directory;


class Helper
{
    public static function isEmpty(string $dir): bool
    {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' && $entry != '..') {
                closedir($handle);
                return false;
            }
        }
        closedir($handle);

        return true;
    }

    public static function getFiles(string $dir, bool $absolute = false): array
    {
        $files = scandir($dir);
        $files = array_slice($files, 2);
        foreach ($files as $k => $file) {
            $aFile = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($aFile)) {
                unset($files[$k]);
                continue;
            }

            if ($absolute) {
                $files[$k] = $aFile;
            }
        }

        return array_values($files);
    }

    public static function delete(string $dir): void
    {
        if (!str_ends_with($dir, '/')) {
            $dir .= '/';
        }

        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                static::delete($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}
