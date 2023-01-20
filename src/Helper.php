<?php


namespace Lump1k\Directory;


class Helper
{
    /**
     * @param string $dir
     * @return bool
     * @throws \Exception
     */
    public static function isEmpty(string $dir): bool
    {
        static::checkIsInvalid($dir);

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

    /**
     * @param string $dir
     * @return void
     * @throws \Exception
     */
    private static function checkIsInvalid(string $dir)
    {
        if (!is_dir($dir)) {
            throw new \Exception('Directory is invalid.', 500);
        }
    }

    /**
     * @param string $dir
     * @param bool $absolute
     * @return array
     * @throws \Exception
     */
    public static function getFiles(string $dir, bool $absolute = false): array
    {
        static::checkIsInvalid($dir);

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

    /**
     * @param string $dir
     * @return void
     * @throws \Exception
     */
    public static function delete(string $dir): void
    {
        static::checkIsInvalid($dir);

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
