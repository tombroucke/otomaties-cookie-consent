<?php
echo '<h2>' . __('What are cookies', 'otomaties-cookie-consent') . '</h2>';
echo '<p>' . __('Cookies are small text files that are stored on your computer or mobile device when you visit a website.', 'otomaties-cookie-consent') . '</p>';
echo '<p>' . __('Every time you visit this website, you will be prompted to <a href="#" data-cc="show-consentModal" aria-haspopup="dialog">accept or refuse cookies</a>', 'otomaties-cookie-consent') . '</p>';
echo '<p>' . __('The purpose is to enable the site to remember your preferences (such as user name, language, etc.) for a certain period of time. That way, you don’t have to re-enter them when browsing around the site during the same visit.', 'otomaties-cookie-consent') . '</p>';
echo '<p>' . __('Cookies can also be used to establish anonymised statistics about the browsing experience on our sites.', 'otomaties-cookie-consent') . '</p>';

echo '<h2>' . __('How can you manage cookies?', 'otomaties-cookie-consent') . '</h2>';
echo '<p>' . __('<a href="#" data-cc="show-preferencesModal" aria-haspopup="dialog">You can manage cookies for this website</a>', 'otomaties-cookie-consent') . '</p>';
echo '<p>' . __('You can delete all cookies that are already on your device by clearing the browsing history of your browser. This will remove all cookies from all websites you have visited.', 'otomaties-cookie-consent') . '</p>';

echo '<h2>' . __('What cookies do we use?', 'otomaties-cookie-consent') . '</h2>';

foreach ($cookiesCategories as $cookiesCategory) {
    if (empty($cookiesCategory['cookies'])) {
        continue;
    }
    echo '<h3>' . $cookiesCategory['name'] . '</h3>';
    echo '<div class="table-responsive">';
    echo '<table class="table table--cookies">';
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
        echo '<td>' . $cookie['name'] . '</td>';
        echo '<td>' . $cookie['domain'] . '</td>';
        echo '<td>' . $cookie['expiration'] . '</td>';
        echo '<td>' . $cookie['description'] . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

if ($linkGooglePrivacyTerms) {
    echo '<p>';
    echo sprintf(
        __('For more information on the privacy practices of Google, please visit the Google Privacy Terms web page: %s.', 'otomaties-cookie-consent'),
        sprintf('<a href="%1$s" target="_blank">%1$s</a>', 'https://policies.google.com/technologies/partner-sites')
    );
    echo '</p>';
}
