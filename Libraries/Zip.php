<?php

namespace WebReinvent\VaahCms\Libraries;

use Exception;
use ZipArchive;

/**
 * Minimal ZipArchive wrapper.
 *
 * Replaces `zanysoft/laravel-zip` (M3-T5-04): the only release compatible with
 * Laravel 13 (1.0.3, no `illuminate/support` pin) fatals on PHP 8.5 with an
 * unparenthesized chained ternary, and no fork release is both Laravel-13-
 * compatible AND PHP 8.5-clean. VaahCMS uses exactly five operations —
 * check / open / listFiles / extract / close — so this trimmed, built-in
 * `ZipArchive`-backed stand-in covers the full API surface actually consumed
 * by `ModuleBase` and `ThemeBase` (module/theme install + update).
 *
 * Behaviour mirrors the fork's 1.0.3 method-for-method (extraction mask 0777,
 * same error strings via the ZipArchive status codes), backed by PHP's native
 * ZipArchive (ext-zip) instead of the third-party dependency.
 *
 * Derived from ZanySoft\Zip (info@zanysoft.co, MIT license), trimmed to the
 * methods in use.
 */
class Zip
{
    /**
     * Mask for the extraction folder (if it should be created).
     *
     * @var int
     */
    private int $mask = 0777;

    /**
     * ZipArchive internal pointer.
     *
     * @var \ZipArchive|null
     */
    private $zip_archive = null;

    /**
     * Set the ZipArchive instance.
     *
     * @param ZipArchive $zip
     * @return $this
     */
    public function setArchive(ZipArchive $zip)
    {
        $this->zip_archive = $zip;

        return $this;
    }

    /**
     * Open a zip archive.
     *
     * @param string $zip_file ZIP file name
     * @return $this
     */
    public function open(string $zip_file)
    {
        try {
            $this->setArchive(self::openZipFile($zip_file));
        } catch (Exception $ze) {
            throw $ze;
        }

        return $this;
    }

    /**
     * Check a zip archive.
     *
     * @param string $zip_file ZIP file name
     * @return bool
     */
    public function check($zip_file): bool
    {
        try {
            $zip = self::openZipFile($zip_file, ZipArchive::CHECKCONS);

            $zip->close();
        } catch (Exception $ze) {
            return false;
        }

        return true;
    }

    /**
     * Get a list of file contained in zip archive before extraction.
     *
     * @return array
     */
    public function listFiles()
    {
        $list = [];

        for ($i = 0; $i < $this->zip_archive->numFiles; $i++) {
            $name = $this->zip_archive->getNameIndex($i);

            if ($name === false) {
                throw new Exception(self::getStatus($this->zip_archive->status));
            }

            $list[] = $name;
        }

        return $list;
    }

    /**
     * Extract the archive to a destination.
     *
     * @param string $destination destination path
     * @param array|null $files optional list of files to extract
     * @return bool
     */
    public function extract($destination, $files = null)
    {
        if (empty($destination)) {
            throw new Exception('Invalid destination path');
        }

        if (!file_exists($destination)) {
            $omask = umask(0);

            $action = mkdir($destination, $this->mask, true);

            umask($omask);

            if ($action === false) {
                throw new Exception('Error creating folder ' . $destination);
            }
        }

        if (!is_writable($destination)) {
            throw new Exception('Destination path not writable');
        }

        if (is_array($files) && count($files) != 0) {
            $file_matrix = $files;
        } else {
            $file_matrix = $this->getArchiveFiles();
        }

        $extract = $this->zip_archive->extractTo($destination, $file_matrix);

        if ($extract === false) {
            throw new Exception(self::getStatus($this->zip_archive->status));
        }

        return true;
    }

    /**
     * Close the zip archive.
     *
     * @return bool
     */
    public function close()
    {
        if ($this->zip_archive->close() === false) {
            throw new Exception(self::getStatus($this->zip_archive->status));
        }

        return true;
    }

    /**
     * Build the extraction file-list from the archive entries.
     *
     * @return array
     */
    private function getArchiveFiles()
    {
        $list = [];

        for ($i = 0; $i < $this->zip_archive->numFiles; $i++) {
            $file = $this->zip_archive->statIndex($i);

            if ($file === false) {
                continue;
            }

            $list[] = str_replace('\\', '/', $file['name']);
        }

        return $list;
    }

    /**
     * Open a zip file and return the ZipArchive instance.
     *
     * @param string $zip_file ZIP file name
     * @param int|null $flags ZipArchive open flags
     * @return ZipArchive
     */
    private static function openZipFile($zip_file, $flags = null)
    {
        $zip = new ZipArchive();

        if (is_null($flags)) {
            $open = $zip->open($zip_file);
        } else {
            $open = $zip->open($zip_file, $flags);
        }

        if ($open !== true) {
            throw new \Exception(self::getStatus($open));
        }

        return $zip;
    }

    /**
     * Map a ZipArchive status code to a human-readable message.
     *
     * @param int $code
     * @return string
     */
    private static function getStatus(int $code): string
    {
        $codes = [
            ZipArchive::ER_OK => 'No error',
            ZipArchive::ER_MULTIDISK => 'Multi-disk zip archives not supported',
            ZipArchive::ER_RENAME => 'Renaming temporary file failed',
            ZipArchive::ER_CLOSE => 'Closing zip archive failed',
            ZipArchive::ER_SEEK => 'Seek error',
            ZipArchive::ER_READ => 'Read error',
            ZipArchive::ER_WRITE => 'Write error',
            ZipArchive::ER_CRC => 'CRC error',
            ZipArchive::ER_ZIPCLOSED => 'Containing zip archive was closed',
            ZipArchive::ER_NOENT => 'No such file',
            ZipArchive::ER_EXISTS => 'File already exists',
            ZipArchive::ER_OPEN => 'Can\'t open file',
            ZipArchive::ER_TMPOPEN => 'Failure to create temporary file',
            ZipArchive::ER_ZLIB => 'Zlib error',
            ZipArchive::ER_MEMORY => 'Malloc failure',
            ZipArchive::ER_CHANGED => 'Entry has been changed',
            ZipArchive::ER_COMPNOTSUPP => 'Compression method not supported',
            ZipArchive::ER_EOF => 'Premature EOF',
            ZipArchive::ER_INVAL => 'Invalid argument',
            ZipArchive::ER_NOZIP => 'Not a zip archive',
            ZipArchive::ER_INTERNAL => 'Internal error',
            ZipArchive::ER_INCONS => 'Zip archive inconsistent',
            ZipArchive::ER_REMOVE => 'Can\'t remove file',
            ZipArchive::ER_DELETED => 'Entry has been deleted',
        ];

        if (array_key_exists($code, $codes)) {
            return $codes[$code];
        }

        return sprintf('Unknown status %s', $code);
    }
}
