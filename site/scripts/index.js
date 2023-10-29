
API.Countries.getList().then(result => {
    if(result.success) {
        result.data.forEach(country => {
            $("#temporary").append($("<p>").text(country.name));
        })
    }
});

API.Countries.get(1).then(result => {
    if(result.success) {
        $("#temporary").prepend($("<h1>").text(result.object.name));
    }
});

let params = { id: 1, name: "Afghanistan" };
API.Countries.save(params);