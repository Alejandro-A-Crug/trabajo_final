let language = localStorage.getItem('language') || 'en'; // Default to English if not set

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('language').value = language; // Set the hidden input value
    updateValidationMessages(); // Call your function to update validation messages
});



function switchLanguage(lang) {
    language = lang; // Update the language variable
    localStorage.setItem('language', lang); // Save the selected language in local storage
    
}



// Event listeners for language switch buttons
document.getElementById('switch-to-es').addEventListener('click', () => switchLanguage('es'));
document.getElementById('switch-to-en').addEventListener('click', () => switchLanguage('en'));