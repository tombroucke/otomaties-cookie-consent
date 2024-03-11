<?php

namespace Otomaties\CookieConsent\Database\Abstracts;

abstract class Table
{
    public function get(mixed $primaryKeyValue)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        $primaryKey = static::PRIMARY_KEY;
        $sql = "SELECT * FROM $tableName WHERE $primaryKey = %d";
        return $wpdb->get_row($wpdb->prepare($sql, $primaryKeyValue));
    }

    public function insert(array $data)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        $wpdb->insert($tableName, $data);
        return $wpdb->insert_id;
    }

    public function update(mixed $primaryKeyValue, array $data)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        $primaryKey = static::PRIMARY_KEY;
        $wpdb->update($tableName, $data, [$primaryKey => $primaryKeyValue]);
    }

    public function updateOrCreate(array $data, array $where)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        $primaryKey = static::PRIMARY_KEY;
        $sql = "SELECT * FROM $tableName WHERE " . key($where) . " = %s";
        $exists = $wpdb->get_row($wpdb->prepare($sql, current($where)));
        
        if ($exists) {
            $wpdb->update($tableName, $data, $where);
            return $exists->$primaryKey;
        } else {
            $wpdb->insert($tableName, $data);
            return $wpdb->insert_id;
        }
    }

    public function delete(mixed $primaryKeyValue)
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        $primaryKey = static::PRIMARY_KEY;
        $wpdb->delete($tableName, [$primaryKey => $primaryKeyValue]);
    }

    public function all()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . static::TABLE_NAME;
        return $wpdb->get_results("SELECT * FROM $tableName");
    }

    public function count()
    {
        return count($this->all());
    }

    public function exists(mixed $primaryKeyValue)
    {
        return $this->get($primaryKeyValue) !== null;
    }

    abstract public static function create() : void;
}
