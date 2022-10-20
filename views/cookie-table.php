<?php
foreach ($cookiesCategories as $cookiesCategory) {
    if (empty($cookiesCategory['cookies'])) {
        continue;
    }
    echo '<h3>' . $cookiesCategory['name'] . '</h3>';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo sprintf('<th class="text-start align-text-left">%s</th>', __('Name', 'otomaties-cookie-consent'));
    echo sprintf('<th class="text-start align-text-left">%s</th>', __('Domain', 'otomaties-cookie-consent'));
    echo sprintf('<th class="text-start align-text-left">%s</th>', __('Expiration', 'otomaties-cookie-consent'));
    echo sprintf('<th class="text-start align-text-left">%s</th>', __('Description', 'otomaties-cookie-consent'));
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($cookiesCategory['cookies'] as $cookie) {
        echo '<tr>';
        echo '<td>' . $cookie['col1'] . '</td>';
        echo '<td>' . $cookie['col2'] . '</td>';
        echo '<td>' . $cookie['col3'] . '</td>';
        echo '<td>' . $cookie['col4'] . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
}
