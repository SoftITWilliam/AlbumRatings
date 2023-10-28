
const API_PATH = "http://localhost:8080/webbutveckling/AlbumRatings/api/index.php";

API.Countries.getList().then(({ success, info, data }) => {
    data.forEach(country => {
        $("#temporary").append($("<p>").text(country.name));
    })
});

API.Countries.getList()