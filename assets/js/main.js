import '../scss/main.scss';
import '../images/cookie.png';

import * as CookieConsent from "vanilla-cookieconsent";

const languages = {};
let categories = {
	necessary : {
		enabled: true,
		readOnly: true,
	},
	analytics : {
		enabled: false,
		readOnly: false,
		autoClear: {
			cookies: []
		}
	}, 
	advertising : {
		enabled: false,
		readOnly: false,
		autoClear: {
			cookies: []
		}
	}, 
	personalization : {
		enabled: false,
		readOnly: false,
		autoClear: {
			cookies: []
		}
	}, 
	security : {
		enabled: false,
		readOnly: false,
		autoClear: {
			cookies: []
		}
	}
};

languages[otomatiesCookieConsent.locale] = {
	consentModal: {
		title: otomatiesCookieConsent.strings.consentModal.title,
		description: otomatiesCookieConsent.strings.consentModal.description,
		acceptAllBtn: otomatiesCookieConsent.strings.consentModal.accept,
		acceptNecessaryBtn: otomatiesCookieConsent.strings.consentModal.reject,
		showPreferencesBtn: otomatiesCookieConsent.strings.consentModal.manage
	},
	preferencesModal: {
		title: otomatiesCookieConsent.strings.settingsModal.title,
		acceptAllBtn: otomatiesCookieConsent.strings.settingsModal.acceptAllBtn,
		acceptNecessaryBtn: otomatiesCookieConsent.strings.settingsModal.rejectAllBtn,
		savePreferencesBtn: otomatiesCookieConsent.strings.settingsModal.saveSettingsBtn,
		closeIconLabel: otomatiesCookieConsent.strings.settingsModal.closeBtnLabel,
		sections: [
			{
				title: otomatiesCookieConsent.strings.sections.usage.title,
				description: otomatiesCookieConsent.strings.sections.usage.description
			},
		],
	}
}
Object.keys(categories).forEach(key => {
	if (otomatiesCookieConsent.strings.sections[key].cookieTable.length || categories[key].enabled || otomatiesCookieConsent.showAllCategories) {
		languages[otomatiesCookieConsent.locale].preferencesModal.sections.push({
			title: otomatiesCookieConsent.strings.sections[key].title,
			description: otomatiesCookieConsent.strings.sections[key].description,
			linkedCategory: key,
			cookieTable: {
				headers: {
					'name': otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.name,
					'domain': otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.domain,
					'expiration': otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.expiration,
					'description': otomatiesCookieConsent.strings.settingsModal.cookieTableHeaders.description,
				},
				body: otomatiesCookieConsent.strings.sections[key].cookieTable
			}
		});
	}
	if(categories[key].autoClear) {
		Object.keys(otomatiesCookieConsent.strings.sections[key].cookieTable).forEach(index => {
			const cookie = otomatiesCookieConsent.strings.sections[key].cookieTable[index];
			categories[key].autoClear.cookies.push({
				'name': cookie.isRegex ? new RegExp(cookie.name) : cookie.name
			});
		});
	}
	console.log(categories)
});

if (otomatiesCookieConsent.strings.sections.moreInformation) {
	languages[otomatiesCookieConsent.locale].preferencesModal.sections.push({
		title: otomatiesCookieConsent.strings.sections.moreInformation.title,
		description: otomatiesCookieConsent.strings.sections.moreInformation.description,
	})	
}

const gtmMapping = {
	'analytics': 'analytics_storage',
	'advertising': 'ad_storage',
	'personalization': 'personalization_storage',
	'security': 'security_storage',
}

CookieConsent.run({
    onConsent: ({cookie, changedCategories, changedPreferences}) => {
		updateGTMConsent(CookieConsent);
    },

    onChange: function (cookie, changed_preferences) {
		updateGTMConsent(CookieConsent);
    },
	
	revision: otomatiesCookieConsent.revision,

    categories: categories,

    language: {
        default: otomatiesCookieConsent.locale,

        translations: languages
    },

	guiOptions: {
		consentModal: {
			layout: otomatiesCookieConsent.guiOptions.consentModal.layout,
			position: otomatiesCookieConsent.guiOptions.consentModal.position,
			flipButtons: !otomatiesCookieConsent.guiOptions.consentModal.swapButtons,
			equalWeightButtons: false,
		},
		preferencesModal: {
			layout: otomatiesCookieConsent.guiOptions.settingsModal.layout,
			position: otomatiesCookieConsent.guiOptions.settingsModal.position,
			flipButtons: !otomatiesCookieConsent.guiOptions.settingsModal.swapButtons,
			equalWeightButtons: false,
		}
	}
});

function updateGTMConsent(CookieConsent) {
	if(otomatiesCookieConsent.gtmConsentMode) {
		let gtmConsent = {};
		Object.keys(gtmMapping).forEach(key => {
			if (CookieConsent.acceptedCategory(key)) {
				gtmConsent[gtmMapping[key]] = 'granted';
			} else {
				gtmConsent[gtmMapping[key]] = 'denied';
			}
		});
		gtag('consent', 'update', gtmConsent);
	}
}

// // obtain plugin


// // run plugin with your configuration
// cc.run({
// 	current_lang: otomatiesCookieConsent.locale,
//     autoclear_cookies: true,                   // default: false
//     page_scripts: true,                        // default: false
// 	revision: otomatiesCookieConsent.revision,
//     gui_options: {
//         consent_modal: {
//             layout: otomatiesCookieConsent.guiOptions.consentModal.layout,
//             position: otomatiesCookieConsent.guiOptions.consentModal.position,
//             transition: otomatiesCookieConsent.guiOptions.consentModal.transition,
//             swap_buttons: otomatiesCookieConsent.guiOptions.consentModal.swapButtons
//         },
//         settings_modal: {
//             layout: otomatiesCookieConsent.guiOptions.settingsModal.layout,
//             position: otomatiesCookieConsent.guiOptions.settingsModal.position,
//             transition: otomatiesCookieConsent.guiOptions.settingsModal.transition,
//         }
//     },

//     // mode: 'opt-in'                          // default: 'opt-in'; value: 'opt-in' or 'opt-out'
//     // delay: 0,                               // default: 0
//     // auto_language: null                     // default: null; could also be 'browser' or 'document'
//     // autorun: true,                          // default: true
//     // force_consent: false,                   // default: false
//     // hide_from_bots: false,                  // default: false
//     // remove_cookie_tables: false             // default: false
//     // cookie_name: 'cc_cookie',               // default: 'cc_cookie'
//     // cookie_expiration: 182,                 // default: 182 (days)
//     // cookie_necessary_only_expiration: 182   // default: disabled
//     // cookie_domain: location.hostname,       // default: current domain
//     // cookie_path: '/',                       // default: root
//     // cookie_same_site: 'Lax',                // default: 'Lax'
//     // use_rfc_cookie: false,                  // default: false

//     onFirstAction: function(user_preferences, cookie){
//         // callback triggered only once
//     },

//     onAccept: function (cookie) {
// 		if (cc.allowedCategory('analytics')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'analytics_storage': 'granted'
// 				});
// 			}
// 		}
// 		if (cc.allowedCategory('advertising')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'ad_storage': 'granted'
// 				});
// 			}
// 		}
// 		if (cc.allowedCategory('personalization')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'personalization_storage': 'granted',
// 				});
// 			}
// 		}
// 		if (cc.allowedCategory('security')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'security_storage': 'granted'
// 				});
// 			}
// 		}
//     },

//     onChange: function (cookie, changed_preferences) {
// 		if (cc.allowedCategory('analytics')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'analytics_storage': 'granted'
// 				});
// 			}
// 		 } else {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'analytics_storage': 'denied'
// 				});
// 			}
// 		 }
// 		 if (cc.allowedCategory('advertising')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'ad_storage': 'granted'
// 				});
// 			}
// 		 } else {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'ad_storage': 'denied'
// 				});
// 			}
// 		 }
// 		 if (cc.allowedCategory('personalization')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'personalization_storage': 'granted',
// 				});
// 			}
// 		 } else {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'personalization_storage': 'denied',
// 				});
// 			}
// 		 }
// 		 if (cc.allowedCategory('security')) {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'security_storage': 'granted'
// 				});
// 			}
// 		 } else {
// 			if(otomatiesCookieConsent.gtmConsentMode) {
// 				gtag('consent', 'update', {
// 					'security_storage': 'denied'
// 				});
// 			}
// 		 }
//     },

// 	languages: languages,
// });
