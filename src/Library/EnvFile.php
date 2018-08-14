<?php

namespace Jeremy379\Toolbox\Library;


class EnvFile
{

    public static function isKeyExistsAndFilled($key) {
        return (! is_null( env($key, null) ) );
    }

    public static function setKey($key, $value) {

        if(is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        file_put_contents(
            self::getEnvFilePath(),
            file_get_contents(self::getEnvFilePath()) . '
'.$key.'="'.$value.'"'
        );

    }

    public static function isFileExists() {
        if(file_exists(self::getEnvFilePath())) {
            return true;
        } else {
            return false;
        }
    }

    public static function createEnvFile() {

        if(file_exists(base_path('.env.example'))) {
            copy(base_path('.env.example'), base_path('.env'));
        } else {
            Throw new \Exception('To generate a .env file, the .env.example file should exists !');
        }
    }

    public static function getEnvFilePath() {
        return base_path('.env');
    }

}