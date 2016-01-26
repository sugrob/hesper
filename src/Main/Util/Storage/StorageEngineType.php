<?php

/*****************************************************************************
 *   Copyright (C) 2006-2009, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-1.0.10.99 at 2013-01-23 15:11:45                     *
 *   This file will never be generated again - feel free to edit.            *
 *****************************************************************************/
namespace Hesper\Main\Util\Storage;

use Hesper\Core\Base\Enum;
use Hesper\Core\Exception\MissingElementException;

class StorageEngineType extends Enum {
    const
        TMP = 0,
        UPLOADED = 1, // Our UploadedFile
        URL = 2,
        WEBDAV = 10,
        FTP = 20,
        IMAGESHACK = 30,
        LOCAL = 40;

    protected static $names = array(
        self::TMP => 'StorageEngine',
        self::UPLOADED => 'StorageEngineUploadedStatic',
        self::URL => 'StorageEngineURL',
        self::WEBDAV => 'StorageEngineWebDAV',
        self::FTP => 'StorageEngineFTP',
        self::IMAGESHACK => 'StorageEngineImageShack',
        self::LOCAL => 'StorageEngineLocal',
    );

    /**
     * @staticx
     * @param $id
     * @return StorageEngineType
     */
    public static function create($id) {
        return new static($id);
    }

    /**
     * @static
     * @param $var String|Object
     * @return StorageEngineType
     */
    public static function getByClass($var) {
        $id = false;
        if (gettype($var) == 'object') {
            $var = get_class($var);
        }

        if (is_scalar($var)) {
            $id = array_search($var, self::getNameList(), true);
        }

        if ($id === false) {
            throw new MissingElementException('No such Storage Engine: ' . $var);
        }

        return self::create($id);
    }

    /**
     * @return StorageEngineType
     */
    public static function tmp() {
        return new self(self::TMP);
    }

    /**
     * @return StorageEngineType
     */
    public static function uploaded() {
        return new self(self::UPLOADED);
    }

    /**
     * @return StorageEngineType
     */
    public static function url() {
        return new self(self::URL);
    }

    /**
     * @return StorageEngineType
     */
    public static function webdav() {
        return new self(self::WEBDAV);
    }

    /**
     * @return StorageEngineType
     */
    public static function ftp() {
        return new self(self::FTP);
    }

    /**
     * @return StorageEngineType
     */
    public static function imageShack() {
        return new self(self::IMAGESHACK);
    }

}

?>