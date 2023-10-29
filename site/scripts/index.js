
API.Countries.getList().then(result => {
    if(result.success) {
        result.data.forEach(country => {
            $("#countries-temp").append($("<p>").text(country.name));
        })
    }
});

//let params = { id: 1, name: "Afghanistan" };
//API.Countries.save(params);

API.Artists.getList().then(result => {
    if(result.success) {
        result.data.forEach(artist => {
            $("#artists-temp").append($("<p>").text(artist.name));
        })
    }
})

// API.Artists.save({ id: 1, name: "100 gecs", years_active: "2015-present", description: "Collaborative project by Laura Les and Dylan Brady." });