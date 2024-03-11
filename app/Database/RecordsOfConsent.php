<?php

namespace Otomaties\CookieConsent\Database;

class RecordsOfConsent extends Abstracts\Table
{
    const PRIMARY_KEY = 'id';
    
    const TABLE_NAME = 'occ_records_of_consent';

    public static function create() : void
    {
        global $wpdb;
        $tableName = $wpdb->prefix . self::TABLE_NAME;
        
        $sql = "CREATE TABLE $tableName (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                ccVersion varchar(255) NULL,
                userAgent varchar(255) NULL,
                remoteAddress varchar(255) NULL,
                forwardedFor varchar(255) NULL,
                acceptType varchar(255) NULL,
                acceptedCategories varchar(255) NULL,
                rejectedCategories varchar(255) NULL,
                acceptedServices varchar(255) NULL,
                rejectedServices varchar(255) NULL,
                UNIQUE KEY id (id)
                );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
