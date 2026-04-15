/**
 * Gestion de l'affichage météo dynamique pour les récits de voyage.
 * Ce script permet d'enrichir l'expérience utilisateur en affichant les conditions 
 * météo réelles du lieu décrit dans l'article grâce aux APIs Open-Meteo.
 */

/**
 * Récupère les coordonnées d'une ville (Geocoding) puis sa météo.
 * La fonction extrait le nom de la ville depuis un attribut 'data-city' dans le HTML,
 * effectue les requêtes asynchrones et injecte le résultat dans le DOM.
 */
const fetchWeather = () => {
    // séléctione le paragraphe avec la class weather
    const weatherDisplay = document.querySelector(".weather");

    // S'il l'élement n'existe pas, le scrimpt arrête
    if (!weatherDisplay) return;

    // Récupération du nom de la ville passé par le PHP via l'attribut data-city
    const cityName = weatherDisplay.getAttribute("data-city");

    if (!cityName) return;

    // URL geo conding, ça traduit la latitude et longitude en nom de la ville
    const geoUrl = `https://geocoding-api.open-meteo.com/v1/search?name=${cityName}&count=10&language=fr&format=json`;

    fetch(geoUrl)
        .then((geoResponse) => geoResponse.json())
        .then((geoData) => {
            // Si l'API Geocoding envoie des résultats
            if (geoData.results && geoData.results.length > 0) {
                const city = geoData.results[0];
                const { latitude, longitude } = city;

                // Utiliser les coordonnées pour obtenir la météo
                const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true`;

                return fetch(weatherUrl);
            }
            throw new Error("City not found");
        })
        .then((weatherResponse) => weatherResponse.json())
        .then((weatherData) => {
            const weather = weatherData.current_weather;

            weatherDisplay.style.display = 'block';
            // Affichage de la météo
            weatherDisplay.innerHTML = `
                Météo à ${cityName} : <strong>${weather.temperature}°C</strong> 
            `;
        })
        // En cas d'erreur
        .catch((error) => {
            weatherDisplay.style.display = 'none';
        });
};

document.addEventListener("DOMContentLoaded", fetchWeather);