
const API_PATH = "http://localhost:8080/webbutveckling/AlbumRatings/api/index.php";

async function apiRequest(moduleName, methodName) {
    if(!moduleName || !methodName) {
        return null;
    }
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${API_PATH}/${moduleName}/${methodName}`
        })
        .then(result => {
            try {
                resolve(JSON.parse(result));
            }
            catch {
                resolve(result);
            }
        })
        .catch(result => resolve(result));
    })
}

apiRequest("country", "get_list").then(({ success, info, data }) => {
    data.forEach(c => {
        $("#temporary").append($("<p>").text(c.name));
    });
});
