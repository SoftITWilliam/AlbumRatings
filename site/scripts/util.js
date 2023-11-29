/**
 * https://gomakethings.com/getting-emoji-from-country-codes-with-vanilla-javascript/
 * 
 * Get the flag emoji for the country
 * @link https://dev.to/jorik/country-code-to-flag-emoji-a21
 * @param  {string} countryCode The country code
 * @return {string}             The flag emoji
 */
function getFlagEmoji (countryCode) {
	let codePoints = countryCode.toUpperCase().split('').map(char =>  127397 + char.charCodeAt());
	return String.fromCodePoint(...codePoints);
}
