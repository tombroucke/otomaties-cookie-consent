import '../scss/main.scss';
import '../images/cookie.png';

import 'vanilla-cookieconsent';

// obtain plugin
var cc = initCookieConsent();

const languages = {};
const categories = {
	'necessary' : {
		enabled: true,
		readonly: true,
	},
	'analytics' : {
		enabled: false,
		readonly: false,
	}, 
	'advertising' : {
		enabled: false,
		readonly: false,
	}, 
	'personalization' : {
		enabled: false,
		readonly: false,
	}, 
	'security' : {
		enabled: false,
		readonly: false,
	}
};

languages[otomatiesCookieConsent.locale] = {
	consent_modal: {
		title: otomatiesCookieConsent.strings.consentModal.title,
		description: otomatiesCookieConsent.strings.consentModal.description,
		primary_btn: {
			text: otomatiesCookieConsent.strings.consentModal.accept,
			role: 'accept_all'              // 'accept_selected' or 'accept_all'
		},
		secondary_btn: {
			text: otomatiesCookieConsent.strings.consentModal.reject,
			role: 'accept_necessary'        // 'settings' or 'accept_necessary'
		}
	},
	settings_modal: {
		title: otomatiesCookieConsent.strings.settingsModal.title,
		save_settings_btn: otomatiesCookieConsent.strings.settingsModal.saveSettingsBtn,
		accept_all_btn: otomatiesCookieConsent.strings.settingsModal.acceptAllBtn,
		reject_all_btn: otomatiesCookieConsent.strings.settingsModal.rejectAllBtn,
		close_btn_label: otomatiesCookieConsent.strings.settingsModal.closeBtnLabel,
		cookie_table_headers: [
			{col1: otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.name},
			{col2: otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.domain},
			{col3: otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.expiration},
			{col4: otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.description}
		],
		blocks: [
			{
				title: otomatiesCookieConsent.strings.blocks.usage.title,
				description: otomatiesCookieConsent.strings.blocks.usage.description
			}
		]
	}
}

Object.keys(categories).forEach(key => {
	if (otomatiesCookieConsent.strings.blocks[key].cookieTable.length || categories[key].enabled || otomatiesCookieConsent.showAllCategories) {
		languages[otomatiesCookieConsent.locale].settings_modal.blocks.push({
			title: otomatiesCookieConsent.strings.blocks[key].title,
			description: otomatiesCookieConsent.strings.blocks[key].description,
			toggle: {
				value: key,
				enabled: categories[key].enabled,
				readonly: categories[key].readonly          // cookie categories with readonly=true are all treated as "necessary cookies"
			},
			cookie_table: otomatiesCookieConsent.strings.blocks[key].cookieTable
		})	
	}
});

if (otomatiesCookieConsent.strings.blocks.moreInformation) {
	languages[otomatiesCookieConsent.locale].settings_modal.blocks.push({
		title: otomatiesCookieConsent.strings.blocks.moreInformation.title,
		description: otomatiesCookieConsent.strings.blocks.moreInformation.description,
	})	
}

// run plugin with your configuration
cc.run({
	current_lang: otomatiesCookieConsent.locale,
    autoclear_cookies: true,                   // default: false
    page_scripts: true,                        // default: false
	revision: otomatiesCookieConsent.revision,
    gui_options: {
        consent_modal: {
            layout: otomatiesCookieConsent.guiOptions.consentModal.layout,
            position: otomatiesCookieConsent.guiOptions.consentModal.position,
            transition: otomatiesCookieConsent.guiOptions.consentModal.transition,
            swap_buttons: otomatiesCookieConsent.guiOptions.consentModal.swapButtons
        },
        settings_modal: {
            layout: otomatiesCookieConsent.guiOptions.settingsModal.layout,
            position: otomatiesCookieConsent.guiOptions.settingsModal.position,
            transition: otomatiesCookieConsent.guiOptions.settingsModal.transition,
        }
    },

    // mode: 'opt-in'                          // default: 'opt-in'; value: 'opt-in' or 'opt-out'
    // delay: 0,                               // default: 0
    // auto_language: null                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                          // default: true
    // force_consent: false,                   // default: false
    // hide_from_bots: false,                  // default: false
    // remove_cookie_tables: false             // default: false
    // cookie_name: 'cc_cookie',               // default: 'cc_cookie'
    // cookie_expiration: 182,                 // default: 182 (days)
    // cookie_necessary_only_expiration: 182   // default: disabled
    // cookie_domain: location.hostname,       // default: current domain
    // cookie_path: '/',                       // default: root
    // cookie_same_site: 'Lax',                // default: 'Lax'
    // use_rfc_cookie: false,                  // default: false

    onFirstAction: function(user_preferences, cookie){
        // callback triggered only once
    },

    onAccept: function (cookie) {
		if (cc.allowedCategory('analytics')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'analytics_storage': 'granted'
				});
			}
		}
		if (cc.allowedCategory('advertising')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'ad_storage': 'granted'
				});
			}
		}
		if (cc.allowedCategory('personalization')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'personalization_storage': 'granted',
				});
			}
		}
		if (cc.allowedCategory('security')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'security_storage': 'granted'
				});
			}
		}
    },

    onChange: function (cookie, changed_preferences) {
		if (cc.allowedCategory('analytics')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'analytics_storage': 'granted'
				});
			}
		 } else {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'analytics_storage': 'denied'
				});
			}
		 }
		 if (cc.allowedCategory('advertising')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'ad_storage': 'granted'
				});
			}
		 } else {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'ad_storage': 'denied'
				});
			}
		 }
		 if (cc.allowedCategory('personalization')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'personalization_storage': 'granted',
				});
			}
		 } else {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'personalization_storage': 'denied',
				});
			}
		 }
		 if (cc.allowedCategory('security')) {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'security_storage': 'granted'
				});
			}
		 } else {
			if(otomatiesCookieConsent.gtmConsentMode) {
				gtag('consent', 'update', {
					'security_storage': 'denied'
				});
			}
		 }
    },

	languages: languages,
});
