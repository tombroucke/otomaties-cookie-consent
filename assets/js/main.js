import '../scss/main.scss';
import '../images/cookie.png';

import * as CookieConsent from "vanilla-cookieconsent";

const languages = {};
const strings = otomatiesCookieConsent.strings;
const sections = strings.sections;
const locale = otomatiesCookieConsent.locale;

document.cc = CookieConsent;

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
	},
};

const gtmCategoryMapping = {
	'analytics': 'analytics_storage',
	'advertising': 'ad_storage',
	'personalization': 'personalization_storage',
	'security': 'security_storage',
}

languages[locale] = {
	consentModal: {
		title: strings.consentModal.title,
		description: strings.consentModal.description,
		acceptAllBtn: strings.consentModal.accept,
		acceptNecessaryBtn: strings.consentModal.reject,
		showPreferencesBtn: strings.consentModal.manage
	},
	preferencesModal: {
		title: strings.settingsModal.title,
		acceptAllBtn: strings.settingsModal.acceptAllBtn,
		acceptNecessaryBtn: strings.settingsModal.rejectAllBtn,
		savePreferencesBtn: strings.settingsModal.saveSettingsBtn,
		closeIconLabel: strings.settingsModal.closeBtnLabel,
		sections: [
			{
				title: sections.usage.title,
				description: sections.usage.description
			},
		],
	}
}

Object.keys(categories).forEach(key => {
	if (Object.keys(sections[key].consentModeParams).length || sections[key].cookieTable.length || sections[key].forceEnable || categories[key].enabled) {
		languages[locale].preferencesModal.sections.push({
			title: sections[key].title,
			description: sections[key].description,
			linkedCategory: key,
			cookieTable: {
				headers: {
					'name': strings.settingsModal.cookieTableHeaders.name,
					'domain': strings.settingsModal.cookieTableHeaders.domain,
					'expiration': strings.settingsModal.cookieTableHeaders.expiration,
					'description': strings.settingsModal.cookieTableHeaders.description,
				},
				body: sections[key].cookieTable
			}
		});

		if (Object.keys(sections[key].consentModeParams).length) {
			Object.keys(sections[key].consentModeParams).forEach(service => {
				categories[key].services = categories[key].services || {};
				categories[key].services[service] = {
					label: sections[key].consentModeParams[service],
				}
			});
		}
	}
	if(sections[key].cookieTable && categories[key].autoClear) {
		Object.keys(sections[key].cookieTable).forEach(index => {
			const cookie = sections[key].cookieTable[index];
			categories[key].autoClear.cookies.push({
				'name': cookie.isRegex ? new RegExp(cookie.name) : cookie.name
			});
		});
	}
});

if (sections.moreInformation) {
	languages[locale].preferencesModal.sections.push({
		title: sections.moreInformation.title,
		description: sections.moreInformation.description,
	})	
}

document.cc.run({
    onConsent: ({cookie, changedCategories, changedPreferences}) => {
		const event = new CustomEvent('cookie_consent_consent_update');
		document.dispatchEvent(event);

		updateGTMConsent(CookieConsent);
    },

    onChange: function (cookie, changed_preferences) {
		const event = new CustomEvent('cookie_consent_consent_update');
		document.dispatchEvent(event);

		updateGTMConsent(CookieConsent);
    },

	page_scripts: true,
	
	revision: otomatiesCookieConsent.revision ? parseInt(otomatiesCookieConsent.revision) : 0,

    categories: categories,

    language: {
        default: locale,
        translations: languages
    },

	guiOptions: {
		consentModal: {
			layout: otomatiesCookieConsent.guiOptions.consentModal.layout,
			position: otomatiesCookieConsent.guiOptions.consentModal.position,
			flipButtons: otomatiesCookieConsent.guiOptions.consentModal.swapButtons,
			equalWeightButtons: false,
		},
		preferencesModal: {
			layout: otomatiesCookieConsent.guiOptions.settingsModal.layout,
			position: otomatiesCookieConsent.guiOptions.settingsModal.position,
			flipButtons: otomatiesCookieConsent.guiOptions.settingsModal.swapButtons,
			equalWeightButtons: false,
		}
	}
});

function updateGTMConsent(CookieConsent) {
	if (otomatiesCookieConsent.gtmConsentMode) {
		let gtmConsent = {};
		Object.keys(categories).forEach(key => {
			const gtmKey = gtmCategoryMapping[key];
			if (!gtmKey) {
				return;
			}
			if (CookieConsent.acceptedCategory(key)) {
				gtmConsent[gtmKey] = 'granted';
			} else {
				gtmConsent[gtmKey] = 'denied';
			}

			if (categories[key].services) {
				Object.keys(categories[key].services).forEach(service => {
					if (CookieConsent.acceptedService(service, key)) {
						gtmConsent[service] = 'granted';
					} else {
						gtmConsent[service] = 'denied';
					}
				});
			}
			
		});
		gtag('consent', 'update', gtmConsent);
	}
}
