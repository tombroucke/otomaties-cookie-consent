import '../scss/admin.scss';

const insertCookieButtons = document.querySelectorAll('button[data-common-cookie]');

for (let index = 0; index < insertCookieButtons.length; index++) {
	const cookieButton = insertCookieButtons[index];
	const cookieName = cookieButton.getAttribute('data-common-cookie');
	const category = cookieButton.getAttribute('data-category');

	cookieButton.addEventListener('click', function (event) {
		event.preventDefault();
		const name = document.querySelector('.' + cookieName + '--name');
		const domain = document.querySelector('.' + cookieName + '--domain');
		const expiration = document.querySelector('.' + cookieName + '--expiration');
		const description = document.querySelector('.' + cookieName + '--description');
		const regex = document.querySelector('.' + cookieName + '--regex').getAttribute('data-regex');
		
		if (typeof(acf) == 'undefined') { return; }

        var repeatDiv = document.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category + '-cookie-table');
        var addRow = repeatDiv.querySelector('.acf-button');
        addRow.click();
        const rowIndex = repeatDiv.querySelectorAll('.acf-row').length - 1;
		const row = repeatDiv.querySelector('.acf-row:nth-child(' + rowIndex + ')');
		const nameInput = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-name input');
		const domainInput = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-domain input');
		const expirationInput = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-expiration input');
		const descriptionInput = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-description input');
		const regexInput = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-regex input[type="hidden"]');
		const regexInputCheckbox = row.querySelector('.acf-field-cookie-consent-category-settings-occ-' + category +'-cookie-table-regex input[type="checkbox"]');

		nameInput.value = name.innerHTML.trim();
		domainInput.value = domain.innerHTML.trim();
		expirationInput.value = expiration.innerHTML.trim();
		descriptionInput.value = description.innerHTML.trim();
		regexInput.checked = regex ? true : false;
		regexInputCheckbox.checked = regex ? true : false;
	});
}
