
API.Countries.getList().then(result => {
    if(result.success) {
        result.data.forEach(country => {
            const $row = $('<tr>');
            $row.append($('<td>').append(country.name));
            $row.append($('<td>').append(country.code));
            $("#countries").append($row);
        })
    }
});

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

API.PrimaryGenres.getList().then(result => {
    if(result.success === false) return;

    // Load and display primary genres
    result.data.forEach(primaryGenre => {

        const $e = $('<div>').addClass('genre-box-temp')
        $e.append($('<h1>').append(primaryGenre.name));
        $('#genres').append($e);

        // Load and display subgenres
        API.PrimaryGenres.getSubgenres(primaryGenre.id).then(result2 => {
            if(result2.success === false) return;
            result2.data.forEach(genre => {
                $e.append($('<p>').append(genre.name));
            })
        })
    });
})

API.Artists.get(1).then(result => console.log(result));
API.Artists.get(2).then(result => console.log(result));

//API.Artists.save({ id: 1, name: "100 gecs", years_active: "2015-present", description: "Collaborative project by Laura Les and Dylan Brady." });
//API.Artists.save({ name: "２８１４", years_active: "2014-present", description: "Collaborative project by 't e l e p a t h テレパシー能力者'  and 'HKE'" });
//API.Artists.save({ name: "Test", years_active: "test-present" });