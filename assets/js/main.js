import '../scss/main.scss';
import '../images/cookie.png';

import 'vanilla-cookieconsent';

// obtain plugin
var cc = initCookieConsent();

const languages = {};
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
			}, {
				title: otomatiesCookieConsent.strings.blocks.necessary.title,
				description: otomatiesCookieConsent.strings.blocks.necessary.description,
				toggle: {
					value: 'necessary',
					enabled: true,
					readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
				},
				cookie_table: otomatiesCookieConsent.strings.blocks.necessary.cookieTable
			}, {
				title: otomatiesCookieConsent.strings.blocks.analytics.title,
				description: otomatiesCookieConsent.strings.blocks.analytics.description,
				toggle: {
					value: 'analytics',     // your cookie category
					enabled: false,
					readonly: false
				},
				cookie_table: otomatiesCookieConsent.strings.blocks.analytics.cookieTable
			}, {
				title: otomatiesCookieConsent.strings.blocks.targeting.title,
				description: otomatiesCookieConsent.strings.blocks.targeting.description,
				toggle: {
					value: 'targeting',
					enabled: false,
					readonly: false
				},
				cookie_table: otomatiesCookieConsent.strings.blocks.targeting.cookieTable
			}
		]
	}
}

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
        // ...
    },

    onChange: function (cookie, changed_preferences) {
        // ...
    },

	languages: languages,
});
