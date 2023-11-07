
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
            const $row = $("<tr>");
            $row.append($("<td>").append(artist.name));
            $row.append($("<td>").append(artist.years_active));
            $row.append($("<td>").append(artist.description));
            $("#artists").append($row);
        })
    }
})

//API.Artists.save({ id: 1, name: "100 gecs", years_active: "2015-present", description: "Collaborative project by Laura Les and Dylan Brady." });
//API.Artists.save({ name: "２８１４", years_active: "2014-present", description: "Collaborative project by 't e l e p a t h テレパシー能力者'  and 'HKE'" });
//API.Artists.save({ name: "Test", years_active: "test-present" });